<?php

namespace App\Domain\Repository\Specialist;

use App\Domain\Entity\Specialist\SpecialistOccupationType;

/**
 * Interface SpecialistOccupationTypeRepositoryInterface.
 */
interface SpecialistOccupationTypeRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return SpecialistOccupationType|null
     */
    public function findById(int $id): ?SpecialistOccupationType;

    /**
     * @return array
     */
    public function findAll();
}
