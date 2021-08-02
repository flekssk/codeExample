<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramFinishedResponseDto;

/**
 * Class SchoolProgramFinishedResponseAssemblerInterface.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram\Assembler
 */
interface SchoolProgramFinishedResponseAssemblerInterface
{
    /**
     * @param object $item
     *
     * @return SchoolProgramFinishedResponseDto
     */
    public function assemble(object $item): SchoolProgramFinishedResponseDto;
}
