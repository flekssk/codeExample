<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Specialist;

use App\Domain\Entity\Specialist\Order;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\Specialist\SpecialistOrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SpecialistOrderRepository.
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Specialist
 */
class SpecialistOrderRepository extends ServiceEntityRepository implements SpecialistOrderRepositoryInterface
{

    /**
     * SpecialistOrderRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): Order
    {
        /** @var Order $order */
        $order = $this->find($id);

        if ($order === null) {
            throw new NotFoundException(sprintf('Order with ID %s not found', (string) $id));
        }

        return $order;
    }

    /**
     * @inheritDoc
     *
     * @throws ORMException
     */
    public function save(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritDoc
     */
    public function findBySpecialistIdAndOrderType(string $specialistId, string $type): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->leftJoin('o.specialists', 's', 'o.id = s.order_id')
            ->where('o.type = :type')
            ->andWhere('s.id = :specialist_id')
            ->setParameter('type', $type)
            ->setParameter('specialist_id', $specialistId)
            ->getQuery()
            ->getResult();
    }
}
