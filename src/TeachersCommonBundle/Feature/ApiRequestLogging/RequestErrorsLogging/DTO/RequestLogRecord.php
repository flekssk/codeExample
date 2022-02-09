<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\DTO;

class RequestLogRecord
{
    private string $serviceDestAlias;

    private string $endpoint;

    private string $method;

    /**
     * @var array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingTraversableTypeHintSpecification
     */
    private array $data;

    private int $statusCode;

    private ?string $body = null;

    private string $serviceSourceAlias;

    /**
     * @param array $data
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function __construct(
        string $serviceDestAlias,
        string $serviceSourceAlias,
        string $endpoint,
        string $method,
        array $data,
        int $statusCode,
        ?string $body
    ) {
        $this->serviceDestAlias = $serviceDestAlias;
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->serviceSourceAlias = $serviceSourceAlias;
    }

    /**
     * @return array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function asArray(): array
    {
        return [
            'server_api' => [
                'source' => $this->serviceSourceAlias,
                'dest' => $this->serviceDestAlias,
                'endpoint' => $this->endpoint,
                'request' => [
                    'method' => $this->method,
                    'data' => $this->data,
                ],
                'response' => [
                    'status' => $this->statusCode,
                    'body' => $this->body,
                ],
            ],
        ];
    }

    public function __toString(): string
    {
        return \GuzzleHttp\json_encode($this->asArray());
    }
}
