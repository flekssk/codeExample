<?php

namespace App\Domain\Repository\Id2;

use App\Domain\Entity\Event\CustomValue;

/**
 * Interface CustomValueRepositoryInterface.
 *
 * @method CustomValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomValue[]    findAll()
 * @method CustomValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Id2
 */
interface CustomValueRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return CustomValue|null
     */
    public function findById(string $id): ?CustomValue;

    /**
     * @return CustomValue[]
     */
    public function findAllEvents(): array;

    /**
     * @param CustomValue $document
     */
    public function save(CustomValue $document): void;

    /**
     * @param CustomValue $document
     */
    public function delete(CustomValue $document): void;
}
