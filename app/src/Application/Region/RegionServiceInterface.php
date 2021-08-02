<?php

namespace App\Application\Region;

use App\Application\Exception\ValidationException;

/**
 * Interface RegionServiceInterface.
 */
interface RegionServiceInterface
{

    /**
     * Поиск по названию
     *
     * @param string $name
     * @param int $count
     * @return array
     * @throws ValidationException
     */
    public function search(string $name, int $count): array;
}
