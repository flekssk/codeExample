<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Trm\Service;

use TeachersTrainingCenterBundle\Api\Trm\DTO\Request\FindTeacherIdsRequestDTO;
use TeachersTrainingCenterBundle\Api\Trm\TrmClient;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Contracts\AssignableUserProviderInterface;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum\CourseAssignmentRulesTargetEnum;
use TeachersTrainingCenterBundle\Feature\Trm\Model\DTO\TrmUser;

class AssignableUserProvider implements AssignableUserProviderInterface
{
    private TrmClient $client;

    public function __construct(TrmClient $client)
    {
        $this->client = $client;
    }

    public function canProvideByContext(CourseAssignmentContext $context): bool
    {
        return $context->getRules()->getTarget()->getValue() === CourseAssignmentRulesTargetEnum::TRM_TARGET;
    }

    /**
     * @inheritDoc
     */
    public function provide(CourseAssignmentContext $context): array
    {
        $request = new FindTeacherIdsRequestDTO(
            $context->getRules()->getRules(),
            1
        );

        $response = $this->client->findTeacherIds($request);

        $result = [];

        do {
            $paginatedTeachers = $this->client->findTeacherIds($request);
            foreach ($response->getTeacherIds() as $userId) {
                $result[] = new TrmUser($userId);
            }

            $request->setPage(
                $request->getPage() + 1
            );
        } while (!$paginatedTeachers->isLastPage());

        return $result;
    }
}
