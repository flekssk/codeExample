<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="`progress`",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="progress__user_id__progress_id__progress_type",
 *             columns={"user_id", "progress_id", "progress_type"}
 *         )
 *     },
 *     options={"comment":"Stores data about lesson/level/etc score and progress"}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Progress
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    public const PROGRESS_TYPE_LESSON = 'lesson';
    public const PROGRESS_TYPE_COURSE = 'course';
    public const PROGRESS_TYPE_LEVEL = 'level';
    public const PROGRESS_TYPES = [
        self::PROGRESS_TYPE_LESSON,
        self::PROGRESS_TYPE_COURSE,
        self::PROGRESS_TYPE_LEVEL,
    ];

    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=40,
     *     nullable=false,
     *     options={"comment":"Id of lesson/course to track progress"}
     * )
     */
    private string $progressId;

    /**
     * @ORM\Column(type="string", length=10, nullable=false, options={"comment":"Lesson/level/etc"})
     */
    private string $progressType;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userProgress")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @var  array{completeness: float, score: float}
     *
     * @ORM\Column(type="json", nullable=false, options={"jsonb": true, "comment":"Score, completeness"})
     */
    private array $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getProgressId(): string
    {
        return $this->progressId;
    }

    public function setProgressId(string $progressId): self
    {
        $this->progressId = $progressId;

        return $this;
    }

    public function getProgressType(): string
    {
        return $this->progressType;
    }

    public function setProgressType(string $progressType): self
    {
        $this->progressType = $progressType;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return array{completeness: float, score: float}
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param array{completeness: float, score: float} $value
     */
    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }
}
