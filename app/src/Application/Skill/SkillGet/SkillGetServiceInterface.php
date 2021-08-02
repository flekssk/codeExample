<?php

namespace App\Application\Skill\SkillGet;

use App\Application\Skill\SkillGet\Dto\SkillResultDto;

/**
 * Interface SkillGetServiceInterface.
 *
 * @package App\Application\Skill\SkillGet
 */
interface SkillGetServiceInterface
{
    /**
     * @return SkillResultDto[]
     */
    public function getAll(): array;

    /**
     * @return array
     */
    public function getAllMacroSkills(): array;

    /**
     * @return array
     */
    public function getAllSortedByMacroSkills(): array;

    /**
     * @param int $id
     * @return array
     */
    public function getBySpecialistId(int $id): array;

    /**
     * @param int $id
     *
     * @return float
     */
    public function getKeySkillsAveragePercentageBySpecialistId(int $id): float;
}
