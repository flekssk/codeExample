<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;

class ConventionalResponseBuilder
{
    public const DEFAULT_RECORDS_PER_PAGE = 1000;

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function success($data, ?SerializationContext $context = null): JsonResponse
    {
        return $this->response(
            ConventionalApiResponseDTO::successfulResult($data),
            Response::HTTP_OK,
            [],
            $context
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function response(
        $data,
        int $status = Response::HTTP_OK,
        array $headers = [],
        ?SerializationContext $context = null
    ): JsonResponse {
        return new JsonResponse(
            $this->serializer->serialize($data, 'json', $context),
            $status,
            $headers,
            true
        );
    }

    public function getDefaultRecordsPerPage(): int
    {
        return self::DEFAULT_RECORDS_PER_PAGE;
    }
}
