<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan;

class LessonPlanByType
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var Step[]
     */
    private $steps;

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Step[]
     */
    public function getSteps(): array
    {
        return $this->steps;
    }
}
