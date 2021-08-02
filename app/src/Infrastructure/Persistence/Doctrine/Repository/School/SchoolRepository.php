<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\School;

use App\Domain\Entity\School\School;
use App\Domain\Repository\School\SchoolRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SchoolRepository.
 *
 * @method School[]    findAll()
 * @method School|null find($id, $lockMode = null, $lockVersion = null)
 * @method School|null findOneBy(array $criteria, array $orderBy = null)
 * @method School[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository
 */
class SchoolRepository extends ServiceEntityRepository implements SchoolRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, School::class);
    }

    /**
     * @inheritDoc
     */
    public function save(School $school): void
    {
        $this->getEntityManager()->persist($school);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(School $school): void
    {
        $this->getEntityManager()->remove($school);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function deleteAll(): void
    {
        $schools = $this->findAll();
        foreach ($schools as $school) {
            $this->delete($school);
        }
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?School
    {
        return $this->findOneBy(['id' => $id]);
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

    /**
     * @inheritdoc
     */
    public function rollback(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $dbConnection->rollBack();
    }
}
