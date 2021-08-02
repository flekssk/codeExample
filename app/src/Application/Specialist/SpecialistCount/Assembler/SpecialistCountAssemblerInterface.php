<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistCount\Assembler;

use App\Application\Specialist\SpecialistCount\Dto\SpecialistCountDto;

/**
 * Interface SpecialistCountAssemblerInterface.
 *
 * @package App\Application\Specialist\SpecialistCountAssembler
 */
interface SpecialistCountAssemblerInterface
{
    /**
     * @param int $count
     *
     * @return SpecialistCountDto
     */
    public function assemble(int $count): SpecialistCountDto;
}
