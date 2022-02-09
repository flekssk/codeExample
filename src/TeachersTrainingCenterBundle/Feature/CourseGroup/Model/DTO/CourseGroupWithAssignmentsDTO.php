<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDTO;

class CourseGroupWithAssignmentsDTO
{
    public int $id;

    public string $title;

    /**
     * @var CourseAssignmentContextDTO[]
     */
    public array $assignments;

    /**
     * @param CourseAssignmentContextDTO[] $assignments
     */
    public function __construct(
        int $id,
        string $title,
        array $assignments
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->assignments = $assignments;
    }
}
