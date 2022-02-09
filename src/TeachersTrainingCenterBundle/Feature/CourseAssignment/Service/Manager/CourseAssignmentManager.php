<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\Manager;

use Doctrine\ORM\EntityManagerInterface;
use TeachersCommonBundle\Contracts\Event\EventMessageSenderInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\EntityNotFoundConventionalException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\TeachersCommonException;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO\CourseAssignmentContextDAO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO\CourseAssignmentRulesDAO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDeletedDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentRules;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Event\CourseAssignmentEvent;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentEventEnvelope;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\CourseAssignService;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DAO\CourseGroupDAO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

class CourseAssignmentManager
{
    private CourseAssignmentContextDAO $assignmentContextDAO;

    private CourseAssignmentRulesDAO $courseAssignmentRulesDAO;

    private CourseGroupDAO $courseGroupDAO;

    private EntityManagerInterface $entityManager;

    private EventMessageSenderInterface $eventMessageSender;

    private CourseAssignService $assigner;

    public function __construct(
        CourseAssignmentContextDAO $assignmentContextDAO,
        CourseGroupDAO $courseGroupDAO,
        CourseAssignmentRulesDAO $courseAssignmentRulesDAO,
        EntityManagerInterface $entityManager,
        EventMessageSenderInterface $eventMessageSender,
        CourseAssignService $assigner
    ) {
        $this->assignmentContextDAO = $assignmentContextDAO;
        $this->courseGroupDAO = $courseGroupDAO;
        $this->courseAssignmentRulesDAO = $courseAssignmentRulesDAO;
        $this->entityManager = $entityManager;
        $this->eventMessageSender = $eventMessageSender;
        $this->assigner = $assigner;
    }

    /**
     * @return CourseAssignmentContextDTO[]
     */
    public function getByCourseGroupId(CourseGroupId $id): array
    {
        $dto = [];

        /** @var CourseAssignmentContext $item */
        foreach ($this->assignmentContextDAO->findByCourseGroupId($id) as $item) {
            $dto[] = $item->toDto();
        }

        return $dto;
    }

    public function createContext(CourseAssignmentContextCreateDTO $dto): CourseAssignmentContextDTO
    {
        $group = $this->courseGroupDAO->find(new CourseGroupId($dto->groupId));
        if (is_null($group)) {
            throw new EntityNotFoundConventionalException($dto->groupId, CourseGroup::class);
        }

        $this->entityManager->beginTransaction();

        try {
            $rules = CourseAssignmentRules::fromCreateDTO(
                $this->courseAssignmentRulesDAO->nextId(),
                $dto->rulesCreateDTO
            );
            $this->courseAssignmentRulesDAO->create($rules);
            $newContextId = $this->assignmentContextDAO->nextId();
            $assignmentContext = new CourseAssignmentContext($newContextId, $group, $rules, $dto->deadlineInDays);

            $this->assignmentContextDAO->create($assignmentContext);

            $this->sendAssignmentMessage($newContextId->value, CourseAssignmentEvent::CREATE_TYPE);
        } catch (\Throwable $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }

        $this->entityManager->commit();

        return $assignmentContext->toDto();
    }

    public function deleteContext(int $contextId): CourseAssignmentContextDeletedDTO
    {
        $this->entityManager->beginTransaction();

        try {
            $context = $this->assignmentContextDAO->find(new CourseAssignmentContextId($contextId));

            if (is_null($context)) {
                throw new EntityNotFoundConventionalException($context, CourseAssignmentContext::class);
            }

            $this->assignmentContextDAO->delete($context);
            $this->courseAssignmentRulesDAO->delete($context->getRules());

            $this->sendAssignmentMessage($context->getId(), CourseAssignmentEvent::DELETE_TYPE);
        } catch (\Throwable $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }

        $this->entityManager->commit();

        return new CourseAssignmentContextDeletedDTO($contextId);
    }

    public function updateContext(CourseAssignmentContextUpdateDTO $dto): CourseAssignmentContextDTO
    {
        $group = $this->courseGroupDAO->find(new CourseGroupId($dto->groupId));
        if (is_null($group)) {
            throw new EntityNotFoundConventionalException($dto->groupId, CourseGroup::class);
        }

        $this->entityManager->beginTransaction();

        try {
            $context = $this->assignmentContextDAO->find(new CourseAssignmentContextId($dto->id));

            if (is_null($context)) {
                throw new EntityNotFoundConventionalException($dto->id, CourseAssignmentContext::class);
            }

            $rules = $context->getRules();

            $this->courseAssignmentRulesDAO->update(
                $rules->update(
                    $dto->rulesUpdateDTO
                )
            );

            $context->setRules($rules);
            $context->setDeadlineInDays($dto->deadlineInDays);

            $this->assignmentContextDAO->update($context);

            $this->sendAssignmentMessage($context->getId(), CourseAssignmentEvent::UPDATE_TYPE);
        } catch (\Throwable $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }

        $this->entityManager->commit();

        return $context->toDto();
    }

    private function sendAssignmentMessage(int $contextId, string $type): void
    {
        if (!CourseAssignmentEvent::isValidType($type)) {
            throw new TeachersCommonException(sprintf('Invalid message type %s', $type));
        }

        $this->assigner->assign(new CourseAssignmentContextId($contextId), $type);

        $this->eventMessageSender->send(
            new CourseAssignmentEventEnvelope(
                new CourseAssignmentEvent(
                    new CourseAssignmentContextId($contextId),
                    $type
                )
            )
        );
    }
}
