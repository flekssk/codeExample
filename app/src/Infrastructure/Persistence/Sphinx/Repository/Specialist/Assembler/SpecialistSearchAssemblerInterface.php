<?php

namespace App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler;

use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;

/**
 * Interface SpecialistFindDtoAssemblerInterface.
 *
 * @package App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler
 */
interface SpecialistSearchAssemblerInterface
{
    /**
     * @param string $searchString
     * @param string $company
     * @param string $id2Position
     * @param string $document
     * @param string $region
     * @param int|null $status
     *
     * @return SpecialistFindDto
     */
    public function assemble(
        string $searchString,
        string $company,
        string $id2Position,
        string $document,
        string $region,
        ?int $status
    ): SpecialistFindDto;
}
