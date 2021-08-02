<?php

namespace App\UI\Controller\Api\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\UI\Controller\Api\Specialist\Dto\SpecialistSearchListResponseDto;

/**
 * Class SpecialistSearchListResponseAssembler.
 *
 * @package App\UI\Controller\Api\Specialist\Assembler
 */
class SpecialistSearchListResponseAssembler implements SpecialistSearchListResponseAssemblerInterface
{
    /**
     * @var SpecialistSearchResponseAssemblerInterface
     */
    private SpecialistSearchResponseAssemblerInterface $searchResponseAssembler;

    public function __construct(SpecialistSearchResponseAssemblerInterface $searchResponseAssembler)
    {
        $this->searchResponseAssembler = $searchResponseAssembler;
    }

    /**
     * @param SpecialistPaginatedListResultDto $specialistPaginatedListResultDto
     *
     * @return SpecialistSearchListResponseDto
     */
    public function assemble(
        SpecialistPaginatedListResultDto $specialistPaginatedListResultDto
    ): SpecialistSearchListResponseDto {
        $dto = new SpecialistSearchListResponseDto();

        $specialists = [];

        foreach ($specialistPaginatedListResultDto->specialists as $item) {
            $specialists[] = $this->searchResponseAssembler->assemble($item);
        }

        $dto->result = $specialists;
        $dto->page = $specialistPaginatedListResultDto->page;
        $dto->perPage = $specialistPaginatedListResultDto->perPage;
        $dto->totalCount = $specialistPaginatedListResultDto->totalCount;

        return $dto;
    }
}
