<?php

namespace App\Application\SchoolProgram\SchoolProgramGet;

/**
 * Interface SchoolProgramGetServiceInterface.
 *
 * @package App\Application\SchoolProgram\SchoolProgramGet
 */
interface SchoolProgramGetServiceInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function getFinishedBySpecialistId(int $id): array;

    /**
     * @param int $id
     * @return array
     */
    public function getNotFinishedBySpecialistId(int $id): array;
}
