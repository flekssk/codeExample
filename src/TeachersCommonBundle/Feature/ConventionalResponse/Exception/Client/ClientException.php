<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientException extends \Exception
{
    protected string $requestBody;
    protected string $responseBody;

    public static function fromRequestResponse(
        RequestInterface $request,
        ResponseInterface $response,
        string $serviceName
    ): self {
        return new static(
            static::buildMessage($serviceName, (string)$request->getUri(), $response->getStatusCode()),
            $response->getStatusCode()
        );
    }

    public static function fromHttpClientException(\Throwable $e, RequestInterface $request, string $serviceName): self
    {
        return new self(
            static::buildMessage($serviceName, (string) $request->getUri(), $e->getCode()),
            (int)$e->getCode(),
            $e
        );
    }

    protected static function buildMessage(string $serviceName, string $uri, int $code): string
    {
        return sprintf('Fail to get data from %s method [%s], code [%d]', $serviceName, $uri, $code);
    }
}
