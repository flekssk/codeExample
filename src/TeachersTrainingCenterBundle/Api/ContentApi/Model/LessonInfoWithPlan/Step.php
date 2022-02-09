<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan;

class Step
{
    /**
     * @var string
     */
    private $stepUUID;

    /**
     * @var string
     */
    private $title;

    public function getStepUUID(): string
    {
        return $this->stepUUID;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
