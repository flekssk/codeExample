<?php

namespace App\Application\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Class SpecialistPaginatedListResultAssembler.
 *
 * @package App\Application\Specialist\Assembler
 */
class SpecialistPaginatedListResultAssembler implements SpecialistPaginatedListResultAssemblerInterface
{
    /**
     * @var SpecialistResultAssemblerInterface
     */
    private SpecialistResultAssemblerInterface $specialistResultAssembler;

    /**
     * SpecialistPaginatedListResultAssembler constructor.
     *
     * @param SpecialistResultAssemblerInterface $specialistResultAssembler
     */
    public function __construct(SpecialistResultAssemblerInterface $specialistResultAssembler)
    {
        $this->specialistResultAssembler = $specialistResultAssembler;
    }

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
    ): SpecialistPaginatedListResultDto {
        $dto = new SpecialistPaginatedListResultDto();

        $specialistsDtoList = [];

        foreach ($specialists as $specialist) {
            $specialistsDtoList[] = $this->specialistResultAssembler->assemble($specialist);
        }

        $dto->specialists = $specialistsDtoList;
        $dto->page = $page;
        $dto->perPage = $perPage;
        $dto->totalCount = $totalCount;

        return $dto;
    }
}
