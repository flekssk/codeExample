<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Assembler;

use App\Application\Specialist\Specialist\Dto\SpecialistAddDto;

/**
 * Class SpecialistAddAssembler.
 *
 * @package App\Application\Specialist\Specialist\Assembler
 */
class SpecialistAddAssembler implements SpecialistAddAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble($options): SpecialistAddDto
    {
        $dto = new SpecialistAddDto();
        $dto->id = (int) $options['id'];

        return $dto;
    }
}
