<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO;

class CourseAssignmentRulesDTO
{
    public int $id;

    /**
     * @var string[]
     */
    public array $rules;

    /**
     * @param string[] $rules
     */
    public function __construct(int $id, array $rules)
    {
        $this->id = $id;
        $this->rules = $rules;
    }
}
