<?php

namespace App\Application\Specialist\SpecialistOrder\Assembler;

use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderResultDto;
use App\Domain\Entity\Specialist\Order;

/**
 * Interface SpecialistOrderResultAssemblerInterface.
 *
 * @package App\Application\Specialist\SpecialistOrder\Assembler
 */
interface SpecialistOrderResultAssemblerInterface
{
    /**
     * @param Order $order
     * @param string $name
     * @param string $pdfUrl
     *
     * @return SpecialistOrderResultDto
     */
    public function assemble(Order $order, string $name, string $pdfUrl): SpecialistOrderResultDto;
}
