<?php

namespace App\Application\Position\Assembler;

use App\Application\Position\Dto\PositionResultDto;
use App\Domain\Entity\Position\Position;

/**
 * Interface PositionResultAssemblerInterface.
 */
interface PositionResultAssemblerInterface
{
    /**
     * @param Position $position
     *
     * @return PositionResultDto
     */
    public function assemble(Position $position): PositionResultDto;
}
