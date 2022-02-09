<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Content\Model\Collection;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Course;

class CourseCollection
{
    /**
     * @var Course[]
     */
    private array $courses;

    /**
     * @param Course ...$courses
     */
    public function __construct(...$courses)
    {
        $this->courses = $courses;
    }
}
