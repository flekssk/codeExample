<?php

namespace App\Application\Skill\SkillGet\Assembler;

use App\Application\Skill\SkillGet\Dto\SkillListResultDto;
use App\Application\Skill\SkillGet\Dto\SkillResultDto;

/**
 * Class SkillListResultAssembler.
 *
 * @package App\Application\Skill\SkillGet\Assembler
 */
class SkillListResultAssembler implements SkillListResultAssemblerInterface
{
    /**
     * @param SkillResultDto[] $list
     *
     * @return SkillListResultDto
     */
    public function assemble(array $list): SkillListResultDto
    {
        $dto = new SkillListResultDto();

        $dto->result = $list;

        return $dto;
    }
}
