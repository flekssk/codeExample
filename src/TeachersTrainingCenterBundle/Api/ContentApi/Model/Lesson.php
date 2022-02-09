<?php

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model;

class Lesson
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $lessonRevId;

    /**
     * @var string
     * @requred
     */
    private $title;

    /**
     * @var string|null
     */
    private $unit;

    /**
     * @var int
     */
    private $unitId;

    /**
     * @var string|null
     */
    private $tags;

    /**
     * @var string|null
     */
    private $grammar;

    /**
     * @var string|null
     */
    private $image;

    /**
     * @var int
     */
    private $programId;

    /**
     * @var string|null
     */
    private $program;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string|null
     */
    private $levelText;

    /**
     * @var int
     */
    private $ageLimit;

    /**
     * @var string|null
     */
    private $section;

    /**
     * @var string|null
     */
    private $plot;

    /**
     * @var bool
     */
    private $isIllegal;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var bool
     */
    private $homeworkReleased;

    /**
     * @var bool
     */
    private $testReleased;

    /**
     * @var int
     */
    private $stepsCount;

    /**
     * @var int
     */
    private $stepsTimeInMinutes;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLessonRevId(): int
    {
        return $this->lessonRevId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getUnitId(): int
    {
        return $this->unitId;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function getGrammar(): ?string
    {
        return $this->grammar;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getProgramId(): int
    {
        return $this->programId;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getLevelText(): ?string
    {
        return $this->levelText;
    }

    public function getAgeLimit(): int
    {
        return $this->ageLimit;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function isIllegal(): bool
    {
        return $this->isIllegal;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function isHomeworkReleased(): bool
    {
        return $this->homeworkReleased;
    }

    public function isTestReleased(): bool
    {
        return $this->testReleased;
    }

    /**
     * @return int
     */
    public function getStepsCount(): int
    {
        return $this->stepsCount;
    }

    /**
     * @return int
     */
    public function getStepsTimeInMinutes(): int
    {
        return $this->stepsTimeInMinutes;
    }
}
