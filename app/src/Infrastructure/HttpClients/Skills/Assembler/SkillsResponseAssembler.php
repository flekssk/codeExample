<?php

namespace App\Infrastructure\HttpClients\Skills\Assembler;

use App\Infrastructure\HttpClients\Skills\Dto\SkillsResponseDto;

/**
 * Class SkillsResponseAssembler.
 *
 * @package App\Infrastructure\HttpClients\Skills\Assembler
 */
class SkillsResponseAssembler implements SkillsResponseAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(object $item): SkillsResponseDto
    {
        $dto = new SkillsResponseDto();

        $dto->id = $item->id;
        $dto->name = $item->name;
        $dto->macroSkillId = $item->macro_skill_id;
        $dto->macroSkillName = $item->macro_skill_name;
        $dto->macroTypeId = $item->macro_type_id;
        $dto->macroTypeName = $item->macro_type_name;
        $dto->reestrId = $item->reestr_id;
        $dto->reestrName = $item->reestr_name;

        return $dto;
    }
}
