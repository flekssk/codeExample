<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Model\DTO;

class CourseDTO
{
    public int $id;

    public string $title;

    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
