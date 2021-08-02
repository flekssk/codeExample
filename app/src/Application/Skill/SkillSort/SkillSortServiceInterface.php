<?php

namespace App\Application\Skill\SkillSort;

use App\Application\Skill\SkillSort\Dto\SkillSortDto;

/**
 * Interface SkillSortServiceInterface.
 *
 * @package App\Application\Skill\SkillSort
 */
interface SkillSortServiceInterface
{
    /**
     * @param SkillSortDto $dto
     *
     * @return bool
     */
    public function saveMacroSkills(SkillSortDto $dto): bool;

    /**
     * @param SkillSortDto $dto
     *
     * @return bool
     */
    public function saveSkills(SkillSortDto $dto): bool;
}
