<?php

namespace App\Infrastructure\HttpClients\Id2\Assembler;

use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;

/**
 * Interface Id2UserAssemblerInterface.
 *
 * @package App\Infrastructure\HttpClients\Id2\Assembler
 */
interface Id2UserAssemblerInterface
{
    /**
     * @param UserGetResponse $userGetResponse
     *
     * @return Id2UserDto
     */
    public function assemble(UserGetResponse $userGetResponse): Id2UserDto;
}
