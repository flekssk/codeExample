<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Service;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\Trm\Service\AssignableUserProvider as TRMAssignableUserProvider;
use TeachersTrainingCenterBundle\Feature\User\Contracts\UserInterface;

class AssignableUserProvider
{
    private TRMAssignableUserProvider $userProvider;

    public function __construct(TRMAssignableUserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @return UserInterface[]
     */
    public function provideByContext(CourseAssignmentContext $context): array
    {
        $users = [];
        if ($this->userProvider->canProvideByContext($context)) {
            $users = $this->userProvider->provide($context);
        }

        return $users;
    }
}
