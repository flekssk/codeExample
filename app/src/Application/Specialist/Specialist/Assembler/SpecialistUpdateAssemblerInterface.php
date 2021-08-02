<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Assembler;

use App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto;

/**
 * Class SpecialistUpdateAssemblerInterface.
 *
 * @package App\Application\Specialist\Specialist\Assembler
 */
interface SpecialistUpdateAssemblerInterface
{
    /**
     * @param array $options
     *
     * @return SpecialistUpdateDto
     */
    public function assemble(array $options): SpecialistUpdateDto;
}
