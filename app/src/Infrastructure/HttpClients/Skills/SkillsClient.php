<?php

namespace App\Infrastructure\HttpClients\Skills;

use App\Infrastructure\HttpClients\UriTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use Psr\Log\LoggerInterface;

/**
 * Class SkillsClient.
 *
 * @package App\Infrastructure\HttpClients\Skills
 */
class SkillsClient implements SkillsClientInterface
{
    use UriTrait;

    /**
     * API v1, получение данных по навыкам по appId.
     */
    private const GET_BY_APPLICATION_ID = '/api/v1/skills_get-by-reestr-application-id';

    /**
     * API v2, получение данных по навыкам по guid реестра.
     */
    private const GET_BY_REGISTRY_ID = '/api/v2/skills_get-by-reestr-id';

    /**
     * API v2, получение данных по навыкам по ID пользователя.
     */
    private const GET_BY_USER_ID = '/api/v2/skill_get-user-by-id';

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string
     */
    private string $defaultRequestTimeout;

    /**
     * SkillsClient constructor.
     *
     * @param string $apiUrl
     * @param LoggerInterface $logger
     * @param string $defaultRequestTimeout
     */
    public function __construct(string $apiUrl, LoggerInterface $logger, string $defaultRequestTimeout)
    {
        $this->apiUrl = $apiUrl;
        $this->logger = $logger;
        $this->httpClient = new Client();
        $this->defaultRequestTimeout = $defaultRequestTimeout;
    }

    /**
     * @inheritDoc
     */
    public function getByRegistryId(string $guid)
    {
        $uri = $this->resolveEndpointUri(
            self::GET_BY_REGISTRY_ID,
            [
                'id' => $guid,
            ]
        );

        try {
            $result = $this->processRequest($uri);
        } catch (RequestException $exception) {
            $result = [];
        }

        return $result;
    }

    /**
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getByUserId(int $id)
    {
        $uri = $this->resolveEndpointUri(
            self::GET_BY_USER_ID,
            [
                'id' => $id,
            ]
        );

        $result = [];

        try {
            $result = $this->processRequest($uri);
        } catch (Exception $e) {
            $this->logger->error('Не удалось получить данные по навыкам специалиста: ' . $e->getMessage());
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
