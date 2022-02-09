<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan;

class LessonInfoWithPlan
{
    /**
     * @var LessonInfo
     */
    private $lessonInfo;

    /**
     * @var LessonPlanByType[]
     */
    private $lessonPlan;

    public function getLessonInfo()
    {
        return $this->lessonInfo;
    }

    /**
     * @return LessonPlanByType[]
     */
    public function getLessonPlan(): array
    {
        return $this->lessonPlan;
    }
}
