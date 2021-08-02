<?php

namespace App\Infrastructure\HttpClients\SchoolProgram;

use App\Infrastructure\HttpClients\UriTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;

/**
 * Class SchoolProgramClient.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram
 */
class SchoolProgramClient implements SchoolProgramClientInterface
{
    use UriTrait;

    /**
     * Получение данных по курсам по ID пользователя и версиям Реестра.
     */
    private const GET_USER_PROGRAMS = '/export-user_programs';

    /**
     * Получение данных по курсам по версиям Реестра.
     */
    private const GET_PROGRAMS = '/export-programs';

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
     * SchoolProgramClient constructor.
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
     *
     * @throws RequestException
     */
    public function getUserProgramsByUserIdAndVersions(int $id, array $versions): array
    {
        $uri = $this->resolveEndpointUri(
            self::GET_USER_PROGRAMS,
            [
                'UserId' => $id,
                'ProductVersionIds' => implode('&ProductVersionIds=', $versions),
            ]
        );

        $response = $this->processRequest($uri);

        return $response ? $response->userPrograms : [];
    }

    /**
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getProgramsByVersions(array $versions): array
    {
        $uri = $this->resolveEndpointUri(
            self::GET_PROGRAMS,
            [
                'ProductVersionIds' => implode('&ProductVersionIds=', $versions),
            ]
        );

        $response = $this->processRequest($uri);

        return $response ? $response->programs : [];
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
