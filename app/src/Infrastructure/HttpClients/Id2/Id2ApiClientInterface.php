<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;

/**
 * Interface Id2ApiClientInterface.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
interface Id2ApiClientInterface
{
    /**
     * @param int $id
     *
     * @return UserGetResponse
     */
    public function getUser(int $id): UserGetResponse;
}
