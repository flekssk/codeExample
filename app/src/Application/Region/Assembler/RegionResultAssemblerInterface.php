<?php

namespace App\Application\Region\Assembler;

use App\Application\Region\Dto\RegionResultDto;
use App\Domain\Entity\Region\Region;

/**
 * Interface RegionResultAssemblerInterface.
 */
interface RegionResultAssemblerInterface
{
    /**
     * @param Region $region
     *
     * @return RegionResultDto
     */
    public function assemble(Region $region): RegionResultDto;
}
