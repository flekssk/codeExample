<?php

namespace App\Application\Skill\SkillGet\Assembler;

use App\Application\Skill\SkillGet\Dto\SkillResultDto;
use App\Domain\Entity\Skill\Skill;

/**
 * Class SkillResultAssembler.
 *
 * @package App\Application\Skill\SkillGet\Assembler
 */
class SkillResultAssembler implements SkillResultAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(Skill $skill): SkillResultDto
    {
        $dto = new SkillResultDto();

        $dto->id = $skill->getId();
        $dto->name = $skill->getName();

        return $dto;
    }
}
