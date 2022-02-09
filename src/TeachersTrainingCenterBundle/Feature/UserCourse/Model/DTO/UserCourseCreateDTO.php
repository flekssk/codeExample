<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;

class UserCourseCreateDTO
{
    private int $userId;

    private int $courseId;

    private ?CourseAssignmentContext $courseAssignmentContext;

    public function __construct(
        int $userId,
        int $courseId,
        ?CourseAssignmentContext $assignmentContext = null
    ) {
        $this->userId = $userId;
        $this->courseId = $courseId;
        $this->courseAssignmentContext = $assignmentContext;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getCourseAssignmentContext(): ?CourseAssignmentContext
    {
        return $this->courseAssignmentContext;
    }
}
