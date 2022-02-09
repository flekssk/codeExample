<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

class CourseAssignmentContextDeletedDTO
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
