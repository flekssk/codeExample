<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject;

class CourseGroupCourses implements \JsonSerializable
{
    /**
     * @var int[]
     */
    private array $courseIds;

    /**
     * @param int[] $courseIds
     */
    public function __construct(int ...$courseIds)
    {
        $this->courseIds = $courseIds;
    }

    /**
     * @return array{courses: array<int>}
     */
    public function jsonSerialize(): array
    {
        return [
            'courses' => $this->courseIds,
        ];
    }

    /**
     * @return int[]
     */
    public function getCourseIds(): array
    {
        return $this->courseIds;
    }
}
