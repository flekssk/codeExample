<?php

namespace App\Application\Specialist\SpecialistOrder\Assembler;

use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderListResultDto;
use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderResultDto;

/**
 * Interface SpecialistOrderListResultAssemblerInterface.
 *
 * @package App\Application\Specialist\SpecialistOrder\Assembler
 */
interface SpecialistOrderListResultAssemblerInterface
{
    /**
     * @param SpecialistOrderResultDto[] $orders
     *
     * @return SpecialistOrderListResultDto
     */
    public function assemble(array $orders): SpecialistOrderListResultDto;
}
