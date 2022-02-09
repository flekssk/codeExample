<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\DeletedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupCourses;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_group")
 */
class CourseGroup
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;
    use DeletedAtEntityTrait;

    /**
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private int $id;

    /**
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     * @ORM\Column(type="string")
     */
    private string $title;

    /**
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     * @ORM\Column(type="text")
     */
    private ?string $description;

    /**
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     * @ORM\Column(type="course_group_courses")
     */
    private CourseGroupCourses $courses;

    public function __construct(
        CourseGroupId $id,
        string $title,
        CourseGroupCourses $courses,
        ?string $description = null
    ) {
        $this->id = $id->value;
        $this->title = $title;
        $this->description = $description;
        $this->courses = $courses;
        $this->createdAt = new \DateTime();
    }

    public static function create(CourseGroupId $id, CourseGroupCreateDTO $createDTO): self
    {
        $courses = new CourseGroupCourses(...$createDTO->courses);

        return new CourseGroup($id, $createDTO->title, $courses, $createDTO->description);
    }

    public function update(CourseGroupUpdateDTO $dto): void
    {
        $this->title = $dto->title;
        $this->description = $dto->description;
        $this->courses = new CourseGroupCourses(...$dto->courses);
        $this->refreshUpdatedAt();
    }

    public function getCourses(): CourseGroupCourses
    {
        return $this->courses;
    }

    public function toDto(): CourseGroupDTO
    {
        return new CourseGroupDTO(
            $this->getId(),
            $this->getTitle(),
            $this->getDescription(),
            $this->courses->getCourseIds()
        );
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
