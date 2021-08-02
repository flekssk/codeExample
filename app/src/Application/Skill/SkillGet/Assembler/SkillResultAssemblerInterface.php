<?php

namespace App\Application\Skill\SkillGet\Assembler;

use App\Application\Skill\SkillGet\Dto\SkillResultDto;
use App\Domain\Entity\Skill\Skill;

/**
 * Interface SkillResultAssemblerInterface.
 *
 * @package App\Application\Skill\SkillGet\Assembler
 */
interface SkillResultAssemblerInterface
{
    /**
     * @param Skill $skill
     *
     * @return SkillResultDto
     */
    public function assemble(Skill $skill): SkillResultDto;
}
