<?php

namespace App\Domain\Repository\SpecialistAccess;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;

/**
 * Interface SpecialistAccessRepositoryInterface.
 */
interface SpecialistAccessRepositoryInterface
{
    /**
     * @param int $specialistId
     * @return SpecialistAccess[]
     */
    public function findAllBySpecialistId(int $specialistId): array;

    /**
     * @param SpecialistAccess $document
     */
    public function save(SpecialistAccess $document): void;

    /**
     * @param SpecialistAccess $document
     */
    public function delete(SpecialistAccess $document): void;

    /**
     * @param int $specialistId
     */
    public function deleteBySpecialistId(int $specialistId): void;

    public function beginTransaction(): void;

    public function commit(): void;
}
