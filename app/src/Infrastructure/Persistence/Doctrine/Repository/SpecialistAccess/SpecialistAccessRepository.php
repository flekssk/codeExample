<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\SpecialistAccess;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Repository\SpecialistAccess\SpecialistAccessRepositoryInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Entity\SpecialistAccess\SpecialistAccess;

/**
 * Class SpecialistAccessRepository.
 */
class SpecialistAccessRepository extends ServiceEntityRepository implements SpecialistAccessRepositoryInterface
{

    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistAccess::class);
    }

    /**
     * @inheritDoc
     */
    public function findAllBySpecialistId(int $specialistId): array
    {
        return $this->findBy([
            'specialistId' => $specialistId
        ]);
    }

    /**
     * @inheritdoc
     */
    public function save(SpecialistAccess $document): void
    {
        try {
            $this->getEntityManager()->persist($document);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(SpecialistAccess $document): void
    {
        try {
            $this->getEntityManager()->remove($document);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteBySpecialistId(int $specialistId): void
    {
        $documents = $this->findAllBySpecialistId($specialistId);
        foreach ($documents as $document) {
            $this->delete($document);
        }
    }

    /**
     * @inheritdoc
     */
    public function beginTransaction(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $dbConnection->beginTransaction();
    }

    /**
     * @inheritdoc
     */
    public function commit(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $entityManager->flush();
        $dbConnection->commit();
    }
}
