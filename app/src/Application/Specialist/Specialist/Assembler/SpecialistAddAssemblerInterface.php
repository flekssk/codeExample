<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Assembler;

use App\Application\Specialist\Specialist\Dto\SpecialistAddDto;

/**
 * Interface SpecialistAddAssemblerInterface.
 *
 * @package App\Application\Specialist\Specialist\Assembler
 */
interface SpecialistAddAssemblerInterface
{
    /**
     * @param array $options
     *
     * @return SpecialistAddDto
     */
    public function assemble(array $options): SpecialistAddDto;
}
