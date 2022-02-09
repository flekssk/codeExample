<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Contracts;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\User\Contracts\UserInterface;

interface AssignableUserProviderInterface
{
    public function canProvideByContext(CourseAssignmentContext $context): bool;

    /**
     * @return UserInterface[]
     */
    public function provide(CourseAssignmentContext $context): array;
}
