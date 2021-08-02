<?php

namespace App\Infrastructure\HttpClients\School\Client;

/**
 * Interface SchoolClientInterface.
 *
 * @package App\Infrastructure\HttpClients\School
 */
interface SchoolClientInterface
{
    /**
     * @return array
     */
    public function getAll(): array;
}
