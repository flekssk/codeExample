<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Service;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientBadRequestException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientServerErrorException;

final class HttpMessageSender
{
    private ClientInterface $httpClient;
    private string $serviceAlias;

    public function __construct(ClientInterface $httpClient, string $serviceAlias)
    {
        $this->httpClient = $httpClient;
        $this->serviceAlias = $serviceAlias;
    }

    /**
     * @param int[] $expectedStatusCodes
     *
     * @throws ClientBadRequestException
     * @throws ClientException
     * @throws ClientServerErrorException
     */
    public function sendRequest(
        RequestInterface $request,
        array $expectedStatusCodes = [Response::HTTP_OK]
    ): ResponseInterface {
        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (\Throwable $e) {
            throw new ClientException(
                'Error with obtain method: ' . $request->getUri() . ' with message: ' . $e->getMessage(),
                (int)$e->getCode(),
                $e
            );
        }

        if (!in_array($response->getStatusCode(), $expectedStatusCodes, true)) {
            $this->throwExceptionOnBadResponse($request, $response);
        }

        return $response;
    }

    public function getServiceAlias(): string
    {
        return $this->serviceAlias;
    }

    /**
     * @throws ClientException|ClientBadRequestException|ClientServerErrorException
     */
    private function throwExceptionOnBadResponse(RequestInterface $request, ResponseInterface $response): void
    {
        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            throw ClientBadRequestException::fromRequestResponse($request, $response, $this->serviceAlias);
        }

        if ($response->getStatusCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            throw ClientServerErrorException::fromRequestResponse($request, $response, $this->serviceAlias);
        }

        throw ClientException::fromRequestResponse($request, $response, $this->serviceAlias);
    }
}
