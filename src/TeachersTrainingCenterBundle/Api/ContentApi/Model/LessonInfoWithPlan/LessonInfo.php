<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan;

class LessonInfo
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $program;

    /**
     * @var string|null
     */
    private $imageUrl;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getProgram(): string
    {
        return $this->program;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }
}
