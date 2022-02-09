<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use TeachersTrainingCenterBundle\Entity\StepProgress;
use TeachersTrainingCenterBundle\Entity\User;

class StepProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StepProgress::class);
    }

    /**
     * @param string[] $value
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(string $stepId, User $user, array $value): StepProgress
    {
        $stepProgress = (new StepProgress())
            ->setStepId($stepId)
            ->setUser($user)
            ->setValue($value);

        $this->getEntityManager()->persist($stepProgress);
        $this->getEntityManager()->flush();

        return $stepProgress;
    }

    /**
     * @param string[] $value
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateValue(StepProgress $stepProgress, array $value): void
    {
        $stepProgress->setValue($value);

        $this->getEntityManager()->persist($stepProgress);
        $this->getEntityManager()->flush();
    }
}
