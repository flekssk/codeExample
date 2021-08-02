<?php

namespace App\Application\Region\Assembler;

use App\Application\Region\Dto\RegionResultDto;
use App\Domain\Entity\Region\Region;

/**
 * Class RegionResultAssembler.
 */
class RegionResultAssembler implements RegionResultAssemblerInterface
{
    /**
     * @inheritdoc
     */
    public function assemble(Region $region): RegionResultDto
    {
        $dto = new RegionResultDto();

        $dto->id = $region->getId();
        $dto->name = $region->getName();

        return $dto;
    }
}
