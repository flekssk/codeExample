<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\EntityRevision;

use App\Domain\Entity\EntityRevision\EntityRevision;
use App\Domain\Repository\EntityRevision\EntityRevisionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EntityRevisionRepository.
 *
 * @method EntityRevision|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityRevision|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityRevision[]    findAll()
 * @method EntityRevision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\EntityRevisionRepository
 */
class EntityRevisionRepository extends ServiceEntityRepository implements EntityRevisionRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityRevision::class);
    }

    /**
     * @param string $id
     *
     * @return EntityRevision|null
     */
    public function findById(string $id)
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function save(EntityRevision $entityRevision): void
    {
        $this->getEntityManager()->persist($entityRevision);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(EntityRevision $entityRevision): void
    {
        $this->getEntityManager()->remove($entityRevision);
        $this->getEntityManager()->flush();
    }
}
