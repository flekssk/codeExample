<?php

namespace App\Application\Specialist\SpecialistOrder\Assembler;

use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderResultDto;
use App\Domain\Entity\Specialist\Order;

/**
 * Class SpecialistOrderResultAssembler.
 *
 * @package App\Application\Specialist\SpecialistOrder\Assembler
 */
class SpecialistOrderResultAssembler implements SpecialistOrderResultAssemblerInterface
{
    /**
     * @param Order $order
     * @param string $name
     * @param string $pdfUrl
     *
     * @return SpecialistOrderResultDto
     */
    public function assemble(Order $order, string $name, string $pdfUrl): SpecialistOrderResultDto
    {
        $dto = new SpecialistOrderResultDto();

        $dto->id = $order->getId();
        $dto->type = $order->getType()->getValue();
        $dto->number = $order->getNumber()->getValue();
        $dto->date = $order->getDate()->format('Y-m-d');
        $dto->name = $name;
        $dto->pdfUrl = $pdfUrl;

        return $dto;
    }
}
