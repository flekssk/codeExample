<?php

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\Repository\ProgressRepository;

class ProgressService
{
    private $progressRepository;

    public function __construct(ProgressRepository $progressRepository)
    {
        $this->progressRepository = $progressRepository;
    }

    public function getProgressForCoursesByUserId(int $userId, array $courseIds = [])
    {
        return $this->progressRepository->getForCoursesByUserId($userId, $courseIds);
    }
}
