<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;

/**
 * Interface Id2ProductsClientInterface.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
interface Id2ProductsClientInterface
{
    /**
     * @param int $id
     * @return SpecialistAccess[]
     */
    public function getAccesses(int $id): array;
}
