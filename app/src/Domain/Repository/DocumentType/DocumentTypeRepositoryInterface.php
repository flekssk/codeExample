<?php

namespace App\Domain\Repository\DocumentType;

use App\Domain\Entity\DocumentType\DocumentType;

/**
 * Interface DocumentTypeRepositoryInterface.
 *
 * @method DocumentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentType[]    findAll()
 * @method DocumentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\DocumentType
 */
interface DocumentTypeRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return DocumentType|null
     */
    public function findById(string $id);

    /**
     * @inheritdoc
     */
    public function save(DocumentType $documentType): void;

    /**
     * @inheritdoc
     */
    public function delete(DocumentType $documentType): void;
}
