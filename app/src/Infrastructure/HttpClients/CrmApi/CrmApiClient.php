<?php

namespace App\Infrastructure\HttpClients\CrmApi;

use App\Infrastructure\HttpClients\CrmApi\Exception\BadResponseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CrmApiClient implements CrmApiClientInterface
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var string[]
     */
    private array $headers;

    /**
     * @var string
     */
    private string $accessToken;

    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @var string
     */
    private string $appId;

    /**
     * @var string
     */
    private string $secretKey;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string
     */
    private string $defaultRequestTimeout;

    /**
     * CrmApiClient constructor.
     * @param LoggerInterface $logger
     * @param string $baseUrl
     * @param string $appId
     * @param string $secretKey
     * @param string $defaultRequestTimeout
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function __construct(
        LoggerInterface $logger,
        string $baseUrl,
        string $appId,
        string $secretKey,
        string $defaultRequestTimeout
    ) {
        $this->logger = $logger;
        $this->baseUrl = $baseUrl;
        $this->appId = $appId;
        $this->secretKey = $secretKey;
        $this->defaultRequestTimeout = $defaultRequestTimeout;

        $this->headers = [
            'Content-type' => 'application/json-patch+json',
            'Accept' => 'application/json',
        ];

        try {
            $this->accessToken = $this->getToken();

            $this->client = HttpClient::createForBaseUri(
                $this->baseUrl,
                [
                    'headers' => $this->headers,
                    'auth_bearer' => $this->accessToken,
                ]
            );
        } catch (\Exception $exception) {
            $this->logger->info('Ошибка при инициализации CRM: ' . $exception->getMessage());
            $this->accessToken = '';
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function getToken(): string
    {
        $client = HttpClient::createForBaseUri(
            $this->baseUrl,
            [
                'headers' => $this->headers,
            ]
        );

        $response = $client->request(
            self::POST_METHOD,
            'token',
            [
                'json' => [
                    'appId' => $this->appId,
                    'secretKey' => $this->secretKey,
                ],
            ],
        );

        $content = $response->toArray();

        if (!isset($content['accessToken'])) {
            throw new BadResponseException('Не удалось получить access token.');
        }

        return $content['accessToken'];
    }

    /**
     * @inheritDoc
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function request(string $url, string $method = self::GET_METHOD, array $data = []): array
    {
        if (empty($this->accessToken)) {
            return [];
        }

        $defaultData = [
            'timeout' => $this->defaultRequestTimeout,
        ];
        $data = array_merge($defaultData, $data);

        return $this->client->request($method, $url, $data)->toArray();
    }
}
