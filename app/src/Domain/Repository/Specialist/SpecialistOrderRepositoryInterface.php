<?php

namespace App\Domain\Repository\Specialist;

use App\Domain\Entity\Specialist\Order;
use App\Domain\Repository\NotFoundException;
use Doctrine\ORM\ORMException;

/**
 * Interface SpecialistOrderRepositoryInterface.
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface SpecialistOrderRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Order
     *
     * @throws NotFoundException
     */
    public function findById(int $id): Order;

    /**
     * @param Order $order
     *
     * @throws ORMException
     */
    public function save(Order $order): void;

    /**
     * @param string $specialistId
     * @param string $type
     *
     * @return Order[]
     */
    public function findBySpecialistIdAndOrderType(string $specialistId, string $type): array;
}
