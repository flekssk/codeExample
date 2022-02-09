<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

/** @psalm-immutable  */
class CourseAssignmentContextCreateDTO
{
    public int $groupId;

    public CourseAssignmentRulesCreateDTO $rulesCreateDTO;

    public ?int $deadlineInDays;

    public function __construct(int $groupId, CourseAssignmentRulesCreateDTO $rulesCreateDTO, ?int $deadlineInDays)
    {
        $this->groupId = $groupId;
        $this->rulesCreateDTO = $rulesCreateDTO;
        $this->deadlineInDays = $deadlineInDays;
    }
}
