<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Region;

use App\Domain\Entity\Region\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\Region\RegionRepositoryInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class RegionRepository.
 *
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionRepository extends ServiceEntityRepository implements RegionRepositoryInterface
{

    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    /**
     * @inheritdoc
     */
    public function save(Region $region): void
    {
        try {
            $this->getEntityManager()->persist($region);
            $this->getEntityManager()->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function findByName(string $name, int $count): array
    {
        $name = mb_strtolower($name);
        return $this->getEntityManager()->createQueryBuilder()
                ->select('r')
                ->from(Region::class, 'r')
                ->andWhere('LOWER(r.name) LIKE :name')
                ->setParameter(':name', "%{$name}%")
                ->setMaxResults($count)
                ->orderBy('r.name')
                ->getQuery()
                ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Region
    {
        return $this->find($id);
    }
}
