<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Id2;

use App\Domain\Entity\Event\CustomValue;
use App\Domain\Repository\Id2\CustomValueRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CustomValueRepository.
 *
 * @method CustomValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomValue[]    findAll()
 * @method CustomValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\CustomValue
 */
class CustomValueRepository extends ServiceEntityRepository implements CustomValueRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomValue::class);
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?CustomValue
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findAllEvents(): array
    {
        return $this->findAll();
    }

    /**
     * @inheritdoc
     */
    public function save(CustomValue $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(CustomValue $document): void
    {
        $this->getEntityManager()->remove($document);
        $this->getEntityManager()->flush();
    }
}
