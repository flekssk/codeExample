<?php

namespace App\UI\Controller\Api\Region\Assembler;

use App\Application\Region\Dto\RegionResultDto;
use App\UI\Controller\Api\Region\Dto\RegionResponseDto;

/**
 * Interface RegionResponseAssemblerInterface.
 *
 * @package App\UI\Controller\Api\Region\Assembler
 */
interface RegionResponseAssemblerInterface
{
    /**
     * @param RegionResultDto $regionResultDto
     *
     * @return RegionResponseDto
     */
    public function assembler(RegionResultDto $regionResultDto): RegionResponseDto;
}
