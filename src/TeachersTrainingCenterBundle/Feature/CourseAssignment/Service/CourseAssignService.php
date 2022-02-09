<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Service;

use TeachersCommonBundle\Feature\ConventionalResponse\Exception\TeachersCommonException;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DAO\CourseAssignmentContextDAO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Event\CourseAssignmentEvent;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\ContextAssigner\CourseGroupAssigner;

class CourseAssignService
{
    private CourseGroupAssigner $contextualAssigner;

    private AssignableUserProvider $userProvider;

    private CourseAssignmentContextDAO $contextDAO;

    public function __construct(
        CourseGroupAssigner $contextAssigner,
        AssignableUserProvider $userProvider,
        CourseAssignmentContextDAO $contextDAO
    ) {
        $this->contextualAssigner = $contextAssigner;
        $this->userProvider = $userProvider;
        $this->contextDAO = $contextDAO;
    }

    public function assign(CourseAssignmentContextId $contextId, string $type): void
    {
        if (!CourseAssignmentEvent::isValidType($type)) {
            throw new TeachersCommonException('Invalid type ' . $type);
        }

        if ($type === CourseAssignmentEvent::DELETE_TYPE) {
//            $this->contextualAssigner->unassign($contextId);
        } else {
            $context = $this->contextDAO->find($contextId);
            if (is_null($context)) {
                throw new \UnexpectedValueException(
                    sprintf(
                        'Message incorrect. Property "assignmentContextId"
                    must be existed context id. Provided value: %s.',
                        $contextId->value
                    )
                );
            }

            $users = $this->userProvider->provideByContext($context);
            $this->contextualAssigner->assign($users, $context);
        }
    }
}
