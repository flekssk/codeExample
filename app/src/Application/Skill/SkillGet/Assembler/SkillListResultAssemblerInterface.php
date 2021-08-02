<?php

namespace App\Application\Skill\SkillGet\Assembler;

use App\Application\Skill\SkillGet\Dto\SkillListResultDto;
use App\Application\Skill\SkillGet\Dto\SkillResultDto;

/**
 * Interface SkillListResultAssemblerInterface.
 *
 * @package App\Application\Skill\SkillGet\Assembler
 */
interface SkillListResultAssemblerInterface
{
    /**
     * @param SkillResultDto[] $list
     *
     * @return SkillListResultDto
     */
    public function assemble(array $list): SkillListResultDto;
}
