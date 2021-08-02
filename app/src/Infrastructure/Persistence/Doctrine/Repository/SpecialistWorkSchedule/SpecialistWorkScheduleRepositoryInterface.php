<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule;

use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;

/**
 * Interface SpecialistWorkScheduleRepository.
 *
 * @todo: Перенести репозиторий в Domain.
 */
interface SpecialistWorkScheduleRepositoryInterface
{

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param int $id
     *
     * @return SpecialistWorkSchedule
     */
    public function get(int $id): SpecialistWorkSchedule;
}
