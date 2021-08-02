<?php

namespace App\Infrastructure\HttpClients\CrmApi;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Interface CrmApiClientInterface.
 */
interface CrmApiClientInterface
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';

    /**
     * @param string $url
     * @param string $method
     * @param array $data
     * @return array
     */
    public function request(string $url, string $method = self::GET_METHOD, array $data = []): array;
}
