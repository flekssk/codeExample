<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Service;

use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientBadRequestException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientErrorsException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client\ClientServerErrorException;

final class ConventionalRequestProcessor
{
    private HttpMessageSender $httpMessageSender;

    private SerializerInterface $serializer;

    public function __construct(HttpMessageSender $httpMessageSender, SerializerInterface $serializer)
    {
        $this->httpMessageSender = $httpMessageSender;
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $requestDTO
     *
     * @throws ClientBadRequestException
     * @throws ClientErrorsException
     * @throws ClientException
     * @throws ClientServerErrorException
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     */
    public function processRequest(string $methodUri, $requestDTO, string $responseClass): ConventionalApiResponseDTO
    {
        $body = $this->serializer->serialize($requestDTO, 'json');

        $request = new Request('POST', $methodUri, [], $body);

        $response = $this->httpMessageSender->sendRequest($request);

        /** @var ConventionalApiResponseDTO $result */
        $result = $this->serializer->deserialize((string)$response->getBody(), $responseClass, 'json');

        $this->validateConventionalResponseOrThrow($result, $methodUri);

        return $result;
    }

    /**
     * @throws ClientErrorsException
     */
    private function validateConventionalResponseOrThrow(ConventionalApiResponseDTO $response, string $methodUri): void
    {
        $errorsDTO = $response->errors;

        if ($errorsDTO === null) {
            return;
        }

        throw new ClientErrorsException($errorsDTO, $methodUri, $this->httpMessageSender->getServiceAlias());
    }
}
