<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Infrastructure\HttpClients\Id2\Dto\Id2UserDto;

/**
 * Interface Id2UserServiceInterface.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
interface Id2UserServiceInterface
{
    /**
     * @param int $id
     *
     * @return Id2UserDto
     */
    public function getUserById(int $id): Id2UserDto;
}
