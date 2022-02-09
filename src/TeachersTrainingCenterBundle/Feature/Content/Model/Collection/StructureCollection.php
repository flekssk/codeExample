<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Content\Model\Collection;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Group;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Course;

class StructureCollection
{
    /**
     * @var Course[]
     */
    private array $courses;

    /**
     * @param Group[] $structure
     */
    public function __construct(array $structure)
    {
        $this->courses = [];

        foreach ($structure as $item) {
            $this->courses = array_merge($this->courses, $item->courses);
        }
    }

    public function findCourse(int $courseId): ?Course
    {
        $course = null;

        foreach ($this->courses as $courseInGroup) {
            if ($courseInGroup->id === $courseId) {
                $course = $courseInGroup;
                break;
            }
        }

        return $course;
    }
}
