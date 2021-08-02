<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\SpecialistExperience;

use App\Domain\Entity\SpecialistExperience\SpecialistExperience;
use App\Domain\Repository\SpecialistExperience\SpecialistExperienceRepositoryInterface;
use App\Domain\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SpecialistExperienceRepository.
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\SpecialistExperience
 */
class SpecialistExperienceRepository extends ServiceEntityRepository implements SpecialistExperienceRepositoryInterface
{
    /**
     * SpecialistExperienceRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistExperience::class);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): SpecialistExperience
    {
        /** @var SpecialistExperience $client */
        $client = $this->find($id);

        if ($client === null) {
            throw new NotFoundException(sprintf('SpecialistExperience с ID %s не найден', (string) $id));
        }

        return $client;
    }

    /**
     * @inheritDoc
     */
    public function findBySpecialistId(int $id): array
    {
        $experience = $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from(SpecialistExperience::class, 's')
            ->addSelect('CASE WHEN s.endDate IS NULL THEN 1 ELSE 0 END as HIDDEN endDateIsNull')
            ->andWhere('s.specialistId = :id')
            ->setParameter('id', $id)
            ->addOrderBy('endDateIsNull', 'desc')
            ->addOrderBy('s.startDate', 'desc')
            ->getQuery()
            ->getResult();

        return $experience;
    }

    /**
     * @inheritDoc
     */
    public function save(SpecialistExperience $specialistExperience): void
    {
        try {
            $this->getEntityManager()->persist($specialistExperience);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(SpecialistExperience $specialistExperience): void
    {
        try {
            $this->getEntityManager()->remove($specialistExperience);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }
}
