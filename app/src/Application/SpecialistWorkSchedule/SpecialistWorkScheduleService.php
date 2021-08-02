<?php

namespace App\Application\SpecialistWorkSchedule;

use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule\SpecialistWorkScheduleRepositoryInterface;

/**
 * Class SpecialistWorkScheduleService.
 */
class SpecialistWorkScheduleService
{

    /**
     * @var SpecialistWorkScheduleResultAssembler
     */
    private SpecialistWorkScheduleResultAssembler $assembler;

    /**
     * @var SpecialistWorkScheduleRepositoryInterface
     */
    private SpecialistWorkScheduleRepositoryInterface $repository;

    /**
     * SpecialistWorkScheduleService constructor.
     *
     * @param SpecialistWorkScheduleResultAssembler $assembler
     * @param SpecialistWorkScheduleRepositoryInterface $repository
     */
    public function __construct(
        SpecialistWorkScheduleResultAssembler $assembler,
        SpecialistWorkScheduleRepositoryInterface $repository
    ) {
        $this->assembler = $assembler;
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $dtoObjects = [];
        $workSchedules = $this->repository->findAll();
        foreach ($workSchedules as $workSchedule) {
            $dtoObjects[] = $this->assembler->assemble($workSchedule);
        }

        return $dtoObjects;
    }
}
