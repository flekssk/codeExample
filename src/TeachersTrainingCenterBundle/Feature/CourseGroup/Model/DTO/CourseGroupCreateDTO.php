<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO;

class CourseGroupCreateDTO
{
    public string $title;

    public ?string $description;

    /**
     * @var int[]
     */
    public array $courses;

    /**
     * @param int[] $courses
     */
    public function __construct(string $title, array $courses, ?string $description = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->courses = $courses;
    }
}
