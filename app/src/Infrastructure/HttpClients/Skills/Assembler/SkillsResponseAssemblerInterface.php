<?php

namespace App\Infrastructure\HttpClients\Skills\Assembler;

use App\Infrastructure\HttpClients\Skills\Dto\SkillsResponseDto;

/**
 * Class SkillsResponseAssemblerInterface.
 *
 * @package App\Infrastructure\HttpClients\Skills\Assembler
 */
interface SkillsResponseAssemblerInterface
{
    /**
     * @param object $item
     *
     * @return SkillsResponseDto
     */
    public function assemble(object $item): SkillsResponseDto;
}
