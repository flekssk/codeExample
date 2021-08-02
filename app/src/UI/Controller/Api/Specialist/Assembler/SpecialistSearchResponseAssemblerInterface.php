<?php

namespace App\UI\Controller\Api\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistResultDto;
use App\UI\Controller\Api\Specialist\Dto\SpecialistSearchResponseDto;

/**
 * Interface SpecialistSearchResponseAssemblerInterface.
 *
 * @package App\UI\Controller\Api\Specialist\Assembler
 */
interface SpecialistSearchResponseAssemblerInterface
{
    /**
     * @param SpecialistResultDto $specialistResultDto
     *
     * @return SpecialistSearchResponseDto
     */
    public function assemble(SpecialistResultDto $specialistResultDto): SpecialistSearchResponseDto;
}
