<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\ContentApi\Model;

use TeachersTrainingCenterBundle\Feature\Course\Model\DTO\CourseDTO;

class Course
{
    /**
     * @requred
     */
    private int $id;

    /**
     * @requred
     */
    private string $title;

    /**
     * @var Level[]
     *
     * @requred
     */
    private array $levels;

    private ?\stdClass $group;

    private ?\DateTime $updatedAt;

    private ?\DateTime $createdAt;

    private ?\DateTime $lessonAddedAt;

    private int $ageLimit;

    private int $subject;

    public function setUpdatedAt(?\stdClass $serialisedDate): void
    {
        $this->updatedAt = $serialisedDate ? new \DateTime($serialisedDate->date) : null;
    }

    public function setCreatedAt(?\stdClass $serialisedDate): void
    {
        $this->createdAt = $serialisedDate ? new \DateTime($serialisedDate->date) : null;
    }

    public function setLessonAddedAt(?\stdClass $serialisedDate): void
    {
        $this->lessonAddedAt = $serialisedDate ? new \DateTime($serialisedDate->date) : null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Level[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    /**
     * @return \stdClass|null
     */
    public function getGroup(): ?\stdClass
    {
        return $this->group;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getLessonAddedAt(): ?\DateTime
    {
        return $this->lessonAddedAt;
    }

    public function getAgeLimit(): int
    {
        return $this->ageLimit;
    }

    public function getSubject(): int
    {
        return $this->subject;
    }

    public function toDto(): CourseDTO
    {
        return new CourseDTO(
            $this->getId(),
            $this->getTitle()
        );
    }
}
