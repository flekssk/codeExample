<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Id2;

use App\Domain\Entity\Id2\Id2Event;
use App\Domain\Repository\Id2\Id2EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class Id2EventRepository.
 *
 * @method Id2Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Id2Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Id2Event[]    findAll()
 * @method Id2Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Id2Event
 */
class Id2EventRepository extends ServiceEntityRepository implements Id2EventRepositoryInterface
{
    /**
     * Class constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Id2Event::class);
    }

    /**
     * @inheritdoc
     */
    public function findById(string $id): ?Id2Event
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
    public function save(Id2Event $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(Id2Event $document): void
    {
        $this->getEntityManager()->remove($document);
        $this->getEntityManager()->flush();
    }
}
