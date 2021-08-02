<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Infrastructure\HttpClients\UriTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Id2ProductsClient.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
class Id2ProductsClient implements Id2ProductsClientInterface
{
    use UriTrait;

    const GET_USER_ACTIVE_ACCESSES = '/api/v1/access_get-active-by-user-id';

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
     * Id2ProductsClient constructor.
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
    public function getAccesses(int $id): array
    {
        $uri = $this->resolveEndpointUri(
            self::GET_USER_ACTIVE_ACCESSES,
            [
                'userId' => $id,
            ]
        );

        $accesses = [];

        try {
            $response = $this->httpClient->request('GET', $uri, ['timeout' => $this->defaultRequestTimeout]);
        } catch (ClientException $exception) {
            return $accesses;
        }

        $accessesData = \GuzzleHttp\json_decode($response->getBody()->read((int)$response->getBody()->getSize()), true);
        foreach ($accessesData['accesses'] as $accessData) {
            $access = new SpecialistAccess();
            $access->setSpecialistId($id);
            $access->setProductId($accessData['productVersion']);
            $access->setDateStart(new \DateTimeImmutable($accessData['dateStart']));
            $access->setDateEnd(new \DateTimeImmutable($accessData['dateEnd']));
            $accesses[] = $access;
        }

        return $accesses;
    }
}
