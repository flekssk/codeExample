<?php

namespace App\UI\Controller\Api\SpecialistWorkSchedule\Assembler;

use App\Application\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleResultDto;
use App\UI\Controller\Api\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleDto;

/**
 * Class SpecialistWorkScheduleAssembler.
 */
class SpecialistWorkScheduleAssembler
{

    /**
     * @param SpecialistWorkScheduleResultDto $resultDto
     * @return SpecialistWorkScheduleDto
     */
    public function assemble(SpecialistWorkScheduleResultDto $resultDto): SpecialistWorkScheduleDto
    {
        $dto = new SpecialistWorkScheduleDto();
        $dto->id = $resultDto->id;
        $dto->name = $resultDto->name;
        return $dto;
    }
}
