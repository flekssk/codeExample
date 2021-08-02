<?php

namespace App\Domain\Repository\RegulatoryDocuments;

use App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments;

/**
 * Interface RegulatoryDocumentsRepositoryInterface.
 *
 * @method RegulatoryDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegulatoryDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegulatoryDocuments[]    findAll()
 * @method RegulatoryDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\RegulatoryDocuments
 */
interface RegulatoryDocumentsRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return RegulatoryDocuments|null
     */
    public function findById(string $id): ?RegulatoryDocuments;

    /**
     * @return RegulatoryDocuments[]
     */
    public function findAllActiveDocuments(): array;

    /**
     * @param RegulatoryDocuments $document
     */
    public function save(RegulatoryDocuments $document): void;

    /**
     * @param RegulatoryDocuments $document
     */
    public function delete(RegulatoryDocuments $document): void;

    public function deleteAll(): void;

    public function beginTransaction(): void;

    public function commit(): void;
}
