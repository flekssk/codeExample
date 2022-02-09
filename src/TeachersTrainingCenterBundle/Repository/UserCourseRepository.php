<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseCreateDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity\UserCourse;
use TeachersTrainingCenterBundle\Feature\UserCourse\Service\UserCourseManager;

class UserCourseRepository extends ServiceEntityRepository
{
    private UserCourseManager $userCourseManager;

    public function __construct(ManagerRegistry $registry, UserCourseManager $userCourseManager)
    {
        parent::__construct($registry, UserCourse::class);

        $this->userCourseManager = $userCourseManager;
    }

    /**
     * @return array<array-key, int|null>
     */
    public function getAllowedCourseIdsForUser(int $userId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $data = $qb
            ->select('uc')
            ->from($this->getClassName(), 'uc')
            ->andWhere($qb->expr()->eq('uc.userId', ':userId'))
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();

        return array_map(static fn (UserCourse $userCourse) => $userCourse->getCourseId(), $data);
    }

    /**
     * @return array<array{course_id: int}>
     */
    public function getAllAvailableCourseIds(): array
    {
        $qb = $this->getEntityManager()
            ->getConnection()
            ->createQueryBuilder();
        $qb->select('DISTINCT course_id')->from('user_course');

        return $qb->execute()->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int[] $courseIds
     */
    public function attachCoursesToUser(int $userId, array $courseIds): void
    {
        $userCourseCreateDTOs = [];

        foreach ($courseIds as $courseId) {
            $existingUserCourse = $this->findOneBy(['userId' => $userId, 'courseId' => $courseId]);

            if (!is_null($existingUserCourse)) {
                continue;
            }

            $userCourseCreateDTOs[] = new UserCourseCreateDTO($userId, $courseId);
        }

        $this->userCourseManager->batchCreate($userCourseCreateDTOs);
    }
}
