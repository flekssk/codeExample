<?php

namespace App\UI\Controller\Api\Position\Assembler;

use App\Application\Position\Dto\PositionResultDto;
use App\UI\Controller\Api\Position\Dto\PositionResponseDto;

/**
 * Class PositionResponseAssembler.
 *
 * @package App\UI\Controller\Api\Position\Assembler
 */
class PositionResponseAssembler implements PositionResponseAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(PositionResultDto $positionResultDto): PositionResponseDto
    {
        $dto = new PositionResponseDto();

        $dto->id = $positionResultDto->id;
        $dto->name = $positionResultDto->name;

        return $dto;
    }
}
