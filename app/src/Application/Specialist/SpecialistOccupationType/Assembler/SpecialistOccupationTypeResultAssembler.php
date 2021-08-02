<?php

namespace App\Application\Specialist\SpecialistOccupationType\Assembler;

use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;
use App\Domain\Entity\Specialist\SpecialistOccupationType;

class SpecialistOccupationTypeResultAssembler implements SpecialistOccupationTypeResultAssemblerInterface
{

    /**
     * @inheritdoc
     */
    public function assemble(SpecialistOccupationType $occupationType): SpecialistOccupationTypeResultDto
    {
        $dto = new SpecialistOccupationTypeResultDto();

        $dto->id = $occupationType->getId();
        $dto->name = $occupationType->getName();

        return $dto;
    }
}
