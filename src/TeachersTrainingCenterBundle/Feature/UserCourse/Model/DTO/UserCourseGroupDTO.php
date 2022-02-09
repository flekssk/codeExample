<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO;

class UserCourseGroupDTO
{
    public int $id;

    public string $title;

    public ?string $description;

    /**
     * @var UserCourseWithStructureDTO[]
     */
    public array $userCourses;

    /**
     * @param UserCourseWithStructureDTO[] $userCourses
     */
    public function __construct(int $id, string $title, ?string $description, array $userCourses)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->userCourses = $userCourses;
    }
}
