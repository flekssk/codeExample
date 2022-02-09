<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO;

class CourseAssignmentContextDTO
{
    public int $id;

    public CourseGroupDTO $group;

    public ?int $deadlineInDays;

    public CourseAssignmentRulesDTO $rules;

    public function __construct(
        int $id,
        CourseGroupDTO $groupDTO,
        CourseAssignmentRulesDTO $assignmentRulesDTO,
        ?int $deadlineInDays = null
    ) {
        $this->id = $id;
        $this->rules = $assignmentRulesDTO;
        $this->group = $groupDTO;
        $this->deadlineInDays = $deadlineInDays;
    }
}
