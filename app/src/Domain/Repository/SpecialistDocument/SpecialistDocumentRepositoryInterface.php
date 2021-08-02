<?php

namespace App\Domain\Repository\SpecialistDocument;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use DateTimeInterface;

/**
 * Interface SpecialistDocumentRepositoryInterface.
 *
 * @method SpecialistDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistDocument[]    findAll()
 * @method SpecialistDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface SpecialistDocumentRepositoryInterface
{
    /**
     * @param int $id
     * @return SpecialistDocument
     */
    public function get(int $id): SpecialistDocument;

    /**
     * @param int $specialistId
     * @return array
     */
    public function findAllBySpecialistId(int $specialistId): array;

    /**
     * @param DateTimeInterface $date
     * @return array
     */
    public function findFromDate(DateTimeInterface $date): array;

    /**
     * @param DateTimeInterface $date
     * @param string $template
     *
     * @return array
     */
    public function findSpecialistsIDsFromDateAndByTemplate(DateTimeInterface $date, string $template): array;

    /**
     * @param string $criteria
     *
     * @return array
     */
    public function findIdsByCriteria(string $criteria): array;

    /**
     * @param SpecialistDocument $document
     */
    public function save(SpecialistDocument $document): void;

    /**
     * @param SpecialistDocument $document
     */
    public function delete(SpecialistDocument $document): void;

    /**
     * @param DateTimeInterface $date
     */
    public function deleteFromDate(DateTimeInterface $date): void;

    public function beginTransaction(): void;

    public function commit(): void;
}
