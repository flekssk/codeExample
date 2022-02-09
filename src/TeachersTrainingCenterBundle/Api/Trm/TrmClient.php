<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\Trm;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TeachersTrainingCenterBundle\Api\Trm\DTO\Request\FindTeacherIdsRequestDTO;
use TeachersTrainingCenterBundle\Api\Trm\DTO\Response\FindTeacherIdsResponseDTO;

class TrmClient
{
    private ClientInterface $httpClient;
    private SerializerInterface $serializer;

    public function __construct(ClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    public function findTeacherIds(FindTeacherIdsRequestDTO $request): FindTeacherIdsResponseDTO
    {
        $body = $this->serializer->serialize($request, 'json');

        return $this->processRequest(new Request('POST', '/server-api/v1/teacher/findIds', [], $body));
    }

    /**
     * @param string[] $options
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    private function processRequest(
        RequestInterface $request,
        array $options = []
    ): FindTeacherIdsResponseDTO {
        $response = $this->sendRequest($request, $options);
        $data = json_decode((string)$response->getBody())->data;
        $teachersIds = [];
        $isLastPage = true;

        if (!is_null($data)) {
            $teachersIds = $data->teacherIds;
            $isLastPage = $data->isLastPage;
        }

        return new FindTeacherIdsResponseDTO(
            $teachersIds,
            $isLastPage,
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    private function sendRequest(
        RequestInterface $request,
        array $options = []
    ): ResponseInterface {
        try {
            $response = $this->httpClient->send($request, $options);
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $response;
    }
}
