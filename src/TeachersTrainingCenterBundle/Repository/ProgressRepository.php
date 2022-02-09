<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Entity\User;

class ProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Progress::class);
    }

    /**
     * @return Progress[]
     */
    public function getForCourseAndLessonByUserId(int $userId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from($this->getClassName(), 'p')
            ->where($qb->expr()->eq('IDENTITY(p.user)', ':userId'))
            ->andWhere($qb->expr()->in('p.progressType', ':progressTypes'))
            ->setParameters([
                'userId' => $userId,
                'progressTypes' => [Progress::PROGRESS_TYPE_LESSON, Progress::PROGRESS_TYPE_COURSE],
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int[] $courseIds
     *
     * @return Progress[]
     */
    public function getForCoursesByUserId(int $userId, array $courseIds = []): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('p')
            ->from($this->getClassName(), 'p')
            ->where($qb->expr()->eq('IDENTITY(p.user)', ':userId'))
            ->andWhere($qb->expr()->in('p.progressType', ':progressTypes'))
            ->setParameters([
                'userId' => $userId,
                'progressTypes' => [Progress::PROGRESS_TYPE_COURSE],
            ]);

        if (count($courseIds) > 0) {
            $qb->andWhere($qb->expr()->in('p.progressId', ':progressIds'))->setParameter(':progressIds', $courseIds);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array{completeness: float, score: float} $value
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(string $progressId, string $progressType, User $user, array $value): Progress
    {
        $progress = (new Progress())
            ->setProgressId($progressId)
            ->setProgressType($progressType)
            ->setUser($user)
            ->setValue($value);

        $this->getEntityManager()->persist($progress);
        $this->getEntityManager()->flush();

        return $progress;
    }

    /**
     * @param array{completeness: float, score: float} $value
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateValue(Progress $progress, array $value): void
    {
        $progress->setValue($value);

        $this->getEntityManager()->persist($progress);
        $this->getEntityManager()->flush();
    }
}
