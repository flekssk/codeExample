<?php

namespace App\Infrastructure\HttpClients\Id2;

use App\Domain\Repository\NotFoundException;
use App\Infrastructure\HttpClients\Id2\Response\UserGetResponse;
use App\Infrastructure\HttpClients\UriTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Id2Client.
 *
 * @package App\Infrastructure\HttpClients\Id2
 */
class Id2Client implements Id2ApiClientInterface
{
    use UriTrait;

    /**
     * Endpoint для получения данных о пользователе по его id
     */
    const GET_USER_ENDPOINT_PATH = '/api/v1/user_get-by-id';

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
     * Id2Client constructor.
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
    public function getUser(int $id): UserGetResponse
    {
        $uri = $this->resolveEndpointUri(
            self::GET_USER_ENDPOINT_PATH,
            [
                'userId' => $id,
            ]
        );

        try {
            $response = $this->httpClient->request('GET', $uri, ['timeout' => $this->defaultRequestTimeout]);
        } catch (ClientException $exception) {
            throw new NotFoundException("Пользователь с id {$id} не найден в id2.");
        }

        $userData = \GuzzleHttp\json_decode($response->getBody()->read((int) $response->getBody()->getSize()));

        $responseObject = new UserGetResponse();
        $responseObject->id = $userData->id;
        $responseObject->email = $userData->email;
        $responseObject->phone = $userData->phone;
        $responseObject->firstName = $userData->firstName;
        $responseObject->lastName = $userData->lastName;
        $responseObject->middleName = $userData->middleName;
        $responseObject->gender = $userData->gender;
        $responseObject->properties = $userData->properties;

        $responseObject->birthDate = !is_null($userData->birthdate)
            ? new \DateTimeImmutable($userData->birthdate)
            : null;

        return $responseObject;
    }
}
