<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO;

class CourseGroupUpdateDTO
{
    public int $id;

    public string $title;

    public string $description;

    /**
     * @var int[]|null
     */
    public array $courses;

    /**
     * @var string[]
     */
    public array $rules;

    /**
     * @param int[] $courses
     */
    public function __construct(int $id, string $title, array $courses, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->courses = $courses;
    }
}
