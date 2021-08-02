<?php

namespace App\Domain\Repository\DocumentTemplate;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use DateTimeInterface;

/**
 * Interface DocumentTemplateRepositoryInterface.
 *
 * @method DocumentTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentTemplate[]    findAll()
 * @method DocumentTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Infrastructure\Persistence\Doctrine\Repository\DocumentTemplate
 */
interface DocumentTemplateRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return DocumentTemplate|null
     */
    public function findById(string $id);

    /**
     * @param DateTimeInterface $date
     *
     * @return array
     */
    public function findByDateNotEqualTo(DateTimeInterface $date): array;

    /**
     * @inheritdoc
     */
    public function save(DocumentTemplate $document): void;

    /**
     * @inheritdoc
     */
    public function delete(DocumentTemplate $document): void;

    /**
     * @return void
     */
    public function deleteAll(): void;

    /**
     * @inheritdoc
     */
    public function beginTransaction(): void;

    /**
     * @inheritdoc
     */
    public function commit(): void;
}
