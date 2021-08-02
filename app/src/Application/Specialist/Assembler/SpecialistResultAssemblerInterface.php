<?php

declare(strict_types=1);

namespace App\Application\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Interface SpecialistResultAssemblerInterface.
 *
 * @package App\Application\Specialist\Assembler
 */
interface SpecialistResultAssemblerInterface
{
    /**
     * @param Specialist $specialist
     *
     * @return SpecialistResultDto
     */
    public function assemble(Specialist $specialist): SpecialistResultDto;
}
