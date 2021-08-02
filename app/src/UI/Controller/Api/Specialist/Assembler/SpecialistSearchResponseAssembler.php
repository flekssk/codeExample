<?php

namespace App\UI\Controller\Api\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistResultDto;
use App\UI\Controller\Api\Specialist\Dto\SpecialistSearchResponseDto;

/**
 * Class SpecialistSearchResponseAssembler.
 *
 * @package App\UI\Controller\Api\Specialist\Assembler
 */
class SpecialistSearchResponseAssembler implements SpecialistSearchResponseAssemblerInterface
{
    /**
     * @param SpecialistResultDto $specialistResultDto
     *
     * @return SpecialistSearchResponseDto
     */
    public function assemble(SpecialistResultDto $specialistResultDto): SpecialistSearchResponseDto
    {
        $dto = new SpecialistSearchResponseDto();

        $dto->id = $specialistResultDto->id;
        $dto->firstName = $specialistResultDto->firstName;
        $dto->secondName = $specialistResultDto->secondName;
        $dto->middleName = $specialistResultDto->middleName;
        $dto->id2Position = $specialistResultDto->id2Position ? $specialistResultDto->id2Position : '';
        $dto->region = !is_null($specialistResultDto->region) ? $specialistResultDto->region : null;
        $dto->status = $specialistResultDto->status;
        $dto->company = $specialistResultDto->company;
        $dto->document = $specialistResultDto->document;

        return $dto;
    }
}
