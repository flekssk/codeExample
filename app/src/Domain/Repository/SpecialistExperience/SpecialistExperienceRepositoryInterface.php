<?php

declare(strict_types=1);

namespace App\Domain\Repository\SpecialistExperience;

use App\Domain\Entity\SpecialistExperience\SpecialistExperience;
use App\Domain\Repository\NotFoundException;

/**
 * Interface SpecialistExperienceRepositoryInterface.
 *
 * @package App\Domain\Repository\SpecialistExperience
 */
interface SpecialistExperienceRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return SpecialistExperience
     *
     * @throws NotFoundException
     */
    public function get(int $id): SpecialistExperience;

    /**
     * @param int $id
     * @return SpecialistExperience[]
     */
    public function findBySpecialistId(int $id): array;

    /**
     * @param SpecialistExperience $specialistExperience
     */
    public function save(SpecialistExperience $specialistExperience): void;

    /**
     * @param SpecialistExperience $specialistExperience
     */
    public function delete(SpecialistExperience $specialistExperience): void;
}
