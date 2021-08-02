<?php

namespace App\UI\Controller\Api\Position\Assembler;

use App\Application\Position\Dto\PositionResultDto;
use App\UI\Controller\Api\Position\Dto\PositionResponseDto;

/**
 * Interface PositionResponseAssemblerInterface.
 *
 * @package App\UI\Controller\Api\Position\Assembler
 */
interface PositionResponseAssemblerInterface
{
    /**
     * @param PositionResultDto $positionResultDto
     *
     * @return PositionResponseDto
     */
    public function assemble(PositionResultDto $positionResultDto): PositionResponseDto;
}
