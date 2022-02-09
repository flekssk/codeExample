<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\DeletedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseCreateDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\ValueObject\UserCourseId;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user_course",
 *     uniqueConstraints={
 * @ORM\UniqueConstraint(columns={"user_id", "course_id"})})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class UserCourse
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;
    use DeletedAtEntityTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private int $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private int $courseId;

    /**
     * @ORM\Column(type="datetime_immutable", nullable="true")
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private ?\DateTimeImmutable $deadline;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private ?int $assignmentContextId;

    public function __construct(
        UserCourseId $id,
        int $userId,
        int $courseId,
        ?int $assignmentContextId = null,
        ?\DateTimeImmutable $deadline = null
    ) {
        $this->id = $id->value;
        $this->userId = $userId;
        $this->courseId = $courseId;
        $this->assignmentContextId = $assignmentContextId;
        $this->deadline = $deadline;
    }

    public static function fromCreateDTO(UserCourseId $id, UserCourseCreateDTO $dto): self
    {
        return new self(
            $id,
            $dto->getUserId(),
            $dto->getCourseId(),
            $dto->getCourseAssignmentContext() ? $dto->getCourseAssignmentContext()->getId() : null,
            $dto->getCourseAssignmentContext()
                ? $dto->getCourseAssignmentContext()->calculateDeadlineDateFromNow()
                : null
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int|null
     */
    public function getAssignmentContextId(): ?int
    {
        return $this->assignmentContextId;
    }

    public function getDeadline(): ?\DateTimeImmutable
    {
        return $this->deadline;
    }
}
