<?php

namespace App\Application\Skill\SkillSort\Assembler;

use App\Application\Skill\SkillSort\Dto\SkillSortDto;

/**
 * Class SkillSortMacroSkillAssembler.
 *
 * @package App\Application\Skill\SkillSort\Assembler
 */
class SkillSortAssembler implements SkillSortAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(array $data): SkillSortDto
    {
        $dto = new SkillSortDto();

        $dto->id = $data['id'];
        $dto->index = $data['index'];

        return $dto;
    }
}
