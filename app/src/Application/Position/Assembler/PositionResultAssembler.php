<?php

namespace App\Application\Position\Assembler;

use App\Application\Position\Assembler\PositionResultAssemblerInterface;
use App\Application\Position\Dto\PositionResultDto;
use App\Domain\Entity\Position\Position;

/**
 * Class PositionResultAssembler.
 */
class PositionResultAssembler implements PositionResultAssemblerInterface
{
    /**
     * @inheritdoc
     */
    public function assemble(Position $position): PositionResultDto
    {
        $dto = new PositionResultDto();
        $dto->id = $position->getId();
        $dto->name = $position->getName();

        return $dto;
    }
}
