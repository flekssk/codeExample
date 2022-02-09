<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

use JMS\Serializer\Annotation as Serializer;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum\CourseAssignmentRulesTargetEnum;

/** @psalm-immutable  */
class CourseAssignmentRulesUpdateDTO
{
    public int $id;

    /**
     * @var string[]
     *
     * @Serializer\Type("array<string>")
     */
    public array $rules;

    public CourseAssignmentRulesTargetEnum $target;

    public ?int $deadlineInDays;

    /**
     * @param string[] $rules
     */
    public function __construct(int $id, array $rules, ?int $deadlineInDays = null)
    {
        $this->id = $id;
        $this->rules = $rules;
        $this->target = new CourseAssignmentRulesTargetEnum(CourseAssignmentRulesTargetEnum::TRM_TARGET);
        $this->deadlineInDays = $deadlineInDays;
    }
}
