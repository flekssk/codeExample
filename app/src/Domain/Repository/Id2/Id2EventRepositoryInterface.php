<?php

namespace App\Domain\Repository\Id2;

use App\Domain\Entity\Id2\Id2Event;

/**
 * Interface Id2EventRepositoryInterface.
 *
 * @method Id2Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Id2Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Id2Event[]    findAll()
 * @method Id2Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\Id2
 */
interface Id2EventRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return Id2Event|null
     */
    public function findById(string $id): ?Id2Event;

    /**
     * @return Id2Event[]
     */
    public function findAllEvents(): array;

    /**
     * @param Id2Event $document
     */
    public function save(Id2Event $document): void;

    /**
     * @param Id2Event $document
     */
    public function delete(Id2Event $document): void;
}
