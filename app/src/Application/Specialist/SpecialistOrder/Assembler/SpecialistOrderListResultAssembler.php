<?php

namespace App\Application\Specialist\SpecialistOrder\Assembler;

use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderListResultDto;
use App\Application\Specialist\SpecialistOrder\Dto\SpecialistOrderResultDto;

/**
 * Class SpecialistOrderListResultAssembler.
 *
 * @package App\Application\Specialist\SpecialistOrder\Assembler
 */
class SpecialistOrderListResultAssembler implements SpecialistOrderListResultAssemblerInterface
{
    /**
     * @var SpecialistOrderResultAssemblerInterface
     */
    private SpecialistOrderResultAssemblerInterface $orderResultAssembler;

    /**
     * SpecialistOrderListResultAssembler constructor.
     *
     * @param SpecialistOrderResultAssemblerInterface $orderResultAssembler
     */
    public function __construct(SpecialistOrderResultAssemblerInterface $orderResultAssembler)
    {
        $this->orderResultAssembler = $orderResultAssembler;
    }

    /**
     * @param SpecialistOrderResultDto[] $orders
     *
     * @return SpecialistOrderListResultDto
     */
    public function assemble(array $orders): SpecialistOrderListResultDto
    {
        $dto = new SpecialistOrderListResultDto();

        $list = [];
        foreach ($orders as $order) {
            $list[] = $order;
        }

        $dto->list = $list;

        return $dto;
    }
}
