<?php

namespace App\Application\Specialist\SpecialistOccupationType\Assembler;

use App\Domain\Entity\Specialist\SpecialistOccupationType;
use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;

/**
 * Interface SpecialistOccupationTypeResultAssemblerInterface.
 */
interface SpecialistOccupationTypeResultAssemblerInterface
{

    /**
     *
     * @param SpecialistOccupationType $occupationType
     * @return SpecialistOccupationTypeResultDto
     */
    public function assemble(SpecialistOccupationType $occupationType): SpecialistOccupationTypeResultDto;
}
