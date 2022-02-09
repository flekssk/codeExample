<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

use JMS\Serializer\Annotation as Serializer;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum\CourseAssignmentRulesTargetEnum;

/** @psalm-immutable */
class CourseAssignmentRulesCreateDTO
{
    /**
     * @var string[]
     *
     * @Serializer\Type("array<string>")
     */
    public array $rules;

    public CourseAssignmentRulesTargetEnum $target;

    /**
     * @param string[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
        $this->target = new CourseAssignmentRulesTargetEnum(CourseAssignmentRulesTargetEnum::TRM_TARGET);
    }
}
