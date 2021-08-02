<?php

namespace App\Application\Cache;

/**
 * Interface CacheServiceInterface.
 *
 * @package App\Application\CacheService
 */
interface CacheServiceInterface
{
    /**
     * @return string
     */
    public function info(): string;

    public function clear(): void;
}
