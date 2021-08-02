<?php

namespace App\UI\Controller\Api\Region\Assembler;

use App\Application\Region\Dto\RegionResultDto;
use App\UI\Controller\Api\Region\Dto\RegionResponseDto;

/**
 * Class RegionResponseAssembler.
 *
 * @package App\UI\Controller\Api\Region\Assembler
 */
class RegionResponseAssembler implements RegionResponseAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assembler(RegionResultDto $regionResultDto): RegionResponseDto
    {
        $dto = new RegionResponseDto();

        $dto->id = $regionResultDto->id;
        $dto->name = $regionResultDto->name;

        return $dto;
    }
}
