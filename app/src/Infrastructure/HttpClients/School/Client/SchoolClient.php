<?php

namespace App\Infrastructure\HttpClients\School\Client;

use App\Infrastructure\HttpClients\UriTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;

/**
 * Class SchoolClient.
 *
 * @package App\Infrastructure\HttpClients\School\Client
 */
class SchoolClient implements SchoolClientInterface
{
    use UriTrait;

    /**
     * URL для получения всех школ.
     */
    private const GET_ALL = '/api/v2/user_groups_get';

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * @var string
     */
    private string $defaultRequestTimeout;

    /**
     * SchoolClient constructor.
     *
     * @param string $apiUrl
     * @param string $defaultRequestTimeout
     */
    public function __construct(string $apiUrl, string $defaultRequestTimeout)
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client();
        $this->defaultRequestTimeout = $defaultRequestTimeout;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $uri = $this->resolveEndpointUri(self::GET_ALL);

        try {
            $result = $this->processRequest($uri);
        } catch (RequestException $exception) {
            $result = [];
        }

        return $result;
    }

    /**
     * @param Uri $uri
     *
     * @return array|mixed
     *
     * @throws RequestException
     */
    private function processRequest(Uri $uri)
    {
        $response = $this->httpClient->request('GET', $uri, ['timeout' => $this->defaultRequestTimeout]);

        return \GuzzleHttp\json_decode($response->getBody()->read((int) $response->getBody()->getSize()));
    }
}
