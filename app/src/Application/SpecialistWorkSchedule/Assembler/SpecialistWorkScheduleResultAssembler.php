<?php

namespace App\Application\SpecialistWorkSchedule\Assembler;

use App\Application\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleResultDto;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;

/**
 * Class SpecialistWorkScheduleResultAssembler.
 */
class SpecialistWorkScheduleResultAssembler
{

    /**
     * @param SpecialistWorkSchedule $workSchedule
     * @return SpecialistWorkScheduleResultDto
     */
    public function assemble(SpecialistWorkSchedule $workSchedule): SpecialistWorkScheduleResultDto
    {
        $dto = new SpecialistWorkScheduleResultDto();
        $dto->id = $workSchedule->getId();
        $dto->name = $workSchedule->getName();
        return $dto;
    }
}
