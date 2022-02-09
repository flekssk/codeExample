<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO;

use JMS\Serializer\Annotation as JMS;

class CourseGroupDTO
{
    public int $id;

    public string $title;

    public ?string $description;

    /**
     * @var int[]
     *
     * @JMS\Type("array<integer>")
     */
    public array $courses;

    /**
     * @param int[] $courses
     */
    public function __construct(int $id, string $title, ?string $description, array $courses)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->courses = $courses;
    }
}
