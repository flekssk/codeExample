<?php

namespace App\Application\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Interface SpecialistPaginatedListResultAssemblerInterface.
 *
 * @package App\Application\Specialist\Assembler
 */
interface SpecialistPaginatedListResultAssemblerInterface
{
    /**
     * @param Specialist[] $specialists
     *
     * @param int          $page
     * @param int          $perPage
     * @param int          $totalCount
     *
     * @return SpecialistPaginatedListResultDto
     */
    public function assemble(
        array $specialists,
        int $page,
        int $perPage,
        int $totalCount
    ): SpecialistPaginatedListResultDto;
}
