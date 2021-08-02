<?php

namespace App\UI\Controller\Api\SpecialistOccupationType\Assembler;

use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;
use App\UI\Controller\Api\SpecialistOccupationType\Dto\SpecialistOccupationTypeResponseDto;

/**
 * Class SpecialistOccupationTypeResponseAssembler.
 */
class SpecialistOccupationTypeResponseAssembler
{

    /**
     * @param SpecialistOccupationTypeResultDto $resultDto
     * @return SpecialistOccupationTypeResponseDto
     */
    public function assemble(SpecialistOccupationTypeResultDto $resultDto): SpecialistOccupationTypeResponseDto
    {
        $dto = new SpecialistOccupationTypeResponseDto();
        $dto->id = $resultDto->id;
        $dto->name = $resultDto->name;
        return $dto;
    }
}
