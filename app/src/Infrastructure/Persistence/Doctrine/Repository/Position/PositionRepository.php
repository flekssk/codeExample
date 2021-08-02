<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Position;

use App\Domain\Entity\Position\Position;
use App\Domain\Entity\Region\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\Position\PositionRepositoryInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class PositionRepository.
 *
 * Репозиторий должностей.
 *
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository implements PositionRepositoryInterface
{

    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    /**
     * @inheritdoc
     */
    public function save(Position $position): void
    {
        try {
            $this->getEntityManager()->persist($position);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
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
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function truncate(): void
    {
        $entityManager = $this->getEntityManager();
        $dbConnection = $entityManager->getConnection();
        $tableName = $entityManager->getClassMetadata(Position::class)
                ->getTableName();
        $platform = $dbConnection->getDatabasePlatform();
        $dbConnection->executeStatement($platform->getTruncateTableSQL($tableName, true));
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

    /**
     * @inheritdoc
     */
    public function searchByName(string $name, int $count): array
    {
        $result = $this->getEntityManager()
                ->createQueryBuilder()
                ->from(Position::class, 'p')
                ->select('p')
                ->andWhere('LOWER(p.name) LIKE :name')
                ->setParameter(':name', "%{$name}%")
                ->setMaxResults($count)
                ->orderBy('p.name')
                ->getQuery()
                ->getResult();

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function replace(Position $position): Position
    {
        $record = $this->findOneBy(['guid' => $position->getGuid()]);
        if ($record) {
            $record->setName($position->getName());
        } else {
            $record = $position;
        }

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        return $record;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Position
    {
        return $this->find($id);
    }
}
