<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\DTO;

class RequestParsedPathParamsDTO
{
    private string $endpoint;

    /**
     * @var string[]|int[]
     */
    private array $params;

    /**
     * @param string[]|int[] $params
     */
    public function __construct(string $endpoint, array $params)
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
    }

    public function endpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string[]|int[]
     */
    public function params(): array
    {
        return $this->params;
    }
}
