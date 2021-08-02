<?php

namespace App\UI\Controller\Api\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\UI\Controller\Api\Specialist\Dto\SpecialistSearchListResponseDto;

/**
 * Interface SpecialistSearchListResponseAssemblerInterface.
 *
 * @package App\UI\Controller\Api\Specialist\Assembler
 */
interface SpecialistSearchListResponseAssemblerInterface
{
    public function assemble(
        SpecialistPaginatedListResultDto $specialistPaginatedListResultDto
    ): SpecialistSearchListResponseDto;
}
