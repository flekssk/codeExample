<?php

namespace App\Application\Specialist\Assembler;

use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;

/**
 * Interface SpecialistResultFromId2AssemblerInterface.
 *
 * @package App\Application\Specialist\Assembler
 */
interface SpecialistResultFromId2AssemblerInterface
{
    /**
     * @param Id2UserDto $userGetResponse
     *
     * @return SpecialistResultDto
     */
    public function assemble(Id2UserDto $userGetResponse): SpecialistResultDto;
}
