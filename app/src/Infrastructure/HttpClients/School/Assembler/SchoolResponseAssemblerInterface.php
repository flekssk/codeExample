<?php

namespace App\Infrastructure\HttpClients\School\Assembler;

use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;

/**
 * Class SchoolResponseAssemblerInterface.
 *
 * @package App\Infrastructure\HttpClients\School\Assembler
 */
interface SchoolResponseAssemblerInterface
{
    /**
     * @param int $id
     * @param string $name
     *
     * @return SchoolResponseDto
     */
    public function assemble(int $id, string $name): SchoolResponseDto;
}
