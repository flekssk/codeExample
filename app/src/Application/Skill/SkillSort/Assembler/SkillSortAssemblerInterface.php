<?php

namespace App\Application\Skill\SkillSort\Assembler;

use App\Application\Skill\SkillSort\Dto\SkillSortDto;

/**
 * Interface SkillSortAssemblerInterface.
 *
 * @package App\Application\Skill\SkillSort\Assembler
 */
interface SkillSortAssemblerInterface
{
    /**
     * @param array $data
     *
     * @return SkillSortDto
     */
    public function assemble(array $data): SkillSortDto;
}
