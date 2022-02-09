<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO;

class UserCourseGroupWithStructureDTO
{
    public int $id;

    public string $title;

    public ?string $description;

    /**
     * @var UserCourseWithStructureDTO[]
     */
    public array $courses;

    /**
     * @param UserCourseWithStructureDTO[] $courses
     */
    public function __construct(int $id, string $title, ?string $description, array $courses)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->courses = $courses;
    }
}
