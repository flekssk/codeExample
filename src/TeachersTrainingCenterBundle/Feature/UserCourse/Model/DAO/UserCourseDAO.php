<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Collection\UserCourseCollection;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity\UserCourse;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\ValueObject\UserCourseId;

class UserCourseDAO
{
    private const MAX_BATCH_TO_SAVE = 50;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function nextId(): UserCourseId
    {
        return new UserCourseId(
            (int) $this->getConnection()
                ->executeQuery('SELECT nextval(\'user_course_id_seq\')')
                ->fetchOne()
        );
    }

    public function save(UserCourse $userCourse): void
    {
        $this->entityManager->persist($userCourse);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * @param UserCourse[] $userCourse
     */
    public function batchSave(array $userCourse): void
    {
        $chunkedCourses = array_chunk($userCourse, self::MAX_BATCH_TO_SAVE);
        foreach ($chunkedCourses as $courses) {
            foreach ($courses as $course) {
                $this->entityManager->persist($course);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }

    /**
     * @param UserCourse[] $deletingEntities
     */
    public function batchDelete(array $deletingEntities): void
    {
        $chunkedCourses = array_chunk($deletingEntities, self::MAX_BATCH_TO_SAVE);

        foreach ($chunkedCourses as $courses) {
            foreach ($courses as $course) {
                $this->entityManager->remove($course);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }

    public function findByUserAndContext(int $userId, int $contextId): UserCourseCollection
    {
        return new UserCourseCollection(
            ...$this->getRepository()->findBy(
                [
                    'userId' => $userId,
                    'assignmentContextId' => $contextId,
                ]
            )
        );
    }

    public function findByUserAndCourse(int $userId, int $courseId): UserCourseCollection
    {
        return new UserCourseCollection(
            ...$this->getRepository()->findBy(
                [
                    'courseId' => $courseId,
                    'userId' => $userId,
                ]
            )
        );
    }

    public function findByUser(int $userId): UserCourseCollection
    {
        return new UserCourseCollection(
            ...$this->getRepository()->findBy(
                [
                    'userId' => $userId,
                ]
            )
        );
    }

    /**
     * @return EntityRepository<UserCourse>
     */
    public function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(UserCourse::class);
    }

    private function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }
}
