<?php

namespace App\Infrastructure\Cache;

use App\Application\Cache\CacheServiceInterface;

/**
 * Class CacheService.
 *
 * @package App\Infrastructure\Cache
 */
class CacheService implements CacheServiceInterface
{
    /**
     * @var \Redis
     */
    private \Redis $redis;

    /**
     * CacheService constructor.
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @inheritDoc
     */
    public function info(): string
    {
        return self::multiImplode((array)$this->redis->info());
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->redis->flushAll();
    }

    /**
     * @param array $array
     * @return string
     */
    private static function multiImplode(array $array): string
    {
        $result = '<ul>';
        foreach ($array as $key => $value) {
            $result .= is_array($value) ? '<p></p><b>' . $key . ': </b>' . self::multiImplode($value) . '<p>' :
                '<li><b>' . $key . ':</b> ' . $value . '</li>';
        }
        return $result . '</ul>';
    }
}
