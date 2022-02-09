<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Service;

use TeachersTrainingCenterBundle\Feature\Course\Model\DAO\CourseDAO;
use TeachersTrainingCenterBundle\Feature\Course\Model\DTO\CourseDTO;

class CourseManager
{
    private CourseDAO $courseDAO;

    public function __construct(CourseDAO $courseDAO)
    {
        $this->courseDAO = $courseDAO;
    }

    /**
     * @return CourseDTO[]
     */
    public function findAll(): array
    {
        $DTOs = [];
        foreach ($this->courseDAO->findAll() as $course) {
            $DTOs[] = $course->toDto();
        }

        return $DTOs;
    }

    /**
     * @param int[] $ids
     *
     * @return CourseDTO[]
     */
    public function findByIds(array $ids): array
    {
        $courses = [];
        $collection = $this->courseDAO->findByIds($ids);

        foreach ($collection as $course) {
            $courses[] = $course->toDto();
        }

        return $courses;
    }
}
