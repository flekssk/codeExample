<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistCount\Assembler;

use App\Application\Specialist\SpecialistCount\Dto\SpecialistCountDto;

/**
 * Class SpecialistCountAssembler.
 *
 * @package App\Application\Specialist\SpecialistCountAssembler
 */
class SpecialistCountAssembler implements SpecialistCountAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(int $count): SpecialistCountDto
    {
        $dto = new SpecialistCountDto();
        $dto->count = $count;

        return $dto;
    }
}
