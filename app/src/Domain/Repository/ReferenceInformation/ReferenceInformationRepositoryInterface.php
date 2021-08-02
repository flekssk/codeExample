<?php

namespace App\Domain\Repository\ReferenceInformation;

use App\Domain\Entity\ReferenceInformation\ReferenceInformation;

/**
 * Interface ReferenceInformationRepositoryInterface.
 *
 * @method ReferenceInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceInformation[]    findAll()
 * @method ReferenceInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\ReferenceInformation
 */
interface ReferenceInformationRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return ReferenceInformation|null
     */
    public function findById(string $id): ?ReferenceInformation;

    /**
     * @return ReferenceInformation[]
     */
    public function findAllActiveInformation(): array;

    /**
     * @param ReferenceInformation $document
     */
    public function save(ReferenceInformation $document): void;

    /**
     * @param ReferenceInformation $document
     */
    public function delete(ReferenceInformation $document): void;

    public function deleteAll(): void;

    public function beginTransaction(): void;

    public function commit(): void;
}
