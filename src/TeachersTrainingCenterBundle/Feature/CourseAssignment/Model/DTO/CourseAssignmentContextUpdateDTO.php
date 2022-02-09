<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

/** @psalm-immutable  */
class CourseAssignmentContextUpdateDTO
{
    public int $id;

    public int $groupId;

    public CourseAssignmentRulesUpdateDTO $rulesUpdateDTO;

    public ?int $deadlineInDays;

    public function __construct(
        int $id,
        int $groupId,
        CourseAssignmentRulesUpdateDTO $rulesCreateDTO,
        ?int $deadlineInDays
    ) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->rulesUpdateDTO = $rulesCreateDTO;
        $this->deadlineInDays = $deadlineInDays;
    }
}
