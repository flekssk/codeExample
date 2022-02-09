<?php

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\Repository\UserCourseRepository;

class UserCourseService
{
    /**
     * @var UserCourseRepository
     */
    private $userCourseRepository;

    public function __construct(UserCourseRepository $userCourseRepository)
    {
        $this->userCourseRepository = $userCourseRepository;
    }

    public function getAllowedCourseIdsForUser(int $userId)
    {
        return $this->userCourseRepository->getAllowedCourseIdsForUser($userId);
    }

    public function getAllAvailableCourseIds()
    {
        return array_map(function ($item) {
            return $item['course_id'];
        }, $this->userCourseRepository->getAllAvailableCourseIds());
    }

    public function attachCoursesToUser(int $userId, array $courseIds)
    {
        $this->userCourseRepository->attachCoursesToUser($userId, $courseIds);
    }
}
