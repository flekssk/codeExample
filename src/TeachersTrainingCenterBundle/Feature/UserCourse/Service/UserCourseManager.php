<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Service;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Collection\UserCourseCollection;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DAO\UserCourseDAO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseCreateDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity\UserCourse;

class UserCourseManager
{
    private UserCourseDAO $userCourseDAO;

    public function __construct(UserCourseDAO $userCourseDAO)
    {
        $this->userCourseDAO = $userCourseDAO;
    }

    public function create(UserCourseCreateDTO $dto): UserCourse
    {
        $userCourse = UserCourse::fromCreateDTO($this->userCourseDAO->nextId(), $dto);

        $this->userCourseDAO->save($userCourse);

        return $userCourse;
    }

    /**
     * @param UserCourseCreateDTO[] $createDTOs
     */
    public function batchCreate(array $createDTOs): void
    {
        $userCourses = [];

        foreach ($createDTOs as $createDTO) {
            $userCourses[] = UserCourse::fromCreateDTO(
                $this->userCourseDAO->nextId(),
                $createDTO
            );
        }

        $this->userCourseDAO->batchSave($userCourses);
    }

    /**
     * @param UserCourse[] $deletingEntities
     */
    public function batchDelete(array $deletingEntities): void
    {
        $this->userCourseDAO->batchDelete($deletingEntities);
    }

    public function findByUserAndContext(int $userId, int $contextId): UserCourseCollection
    {
        return $this->userCourseDAO->findByUserAndContext($userId, $contextId);
    }

    public function findByUserAndCourse(int $userId, int $courseId): UserCourseCollection
    {
        return $this->userCourseDAO->findByUserAndCourse($userId, $courseId);
    }

    public function deleteNotStartedByContextId(CourseAssignmentContextId $id): void
    {
        $this->userCourseDAO->deleteNotStartedByContextId($id);
    }
}
