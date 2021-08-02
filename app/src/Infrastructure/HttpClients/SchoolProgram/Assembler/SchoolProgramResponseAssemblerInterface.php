<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramResponseDto;

/**
 * Class SchoolProgramResponseAssemblerInterface.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram\Assembler
 */
interface SchoolProgramResponseAssemblerInterface
{
    /**
     * @param object $item
     *
     * @return SchoolProgramResponseDto
     */
    public function assemble(object $item): SchoolProgramResponseDto;
}
