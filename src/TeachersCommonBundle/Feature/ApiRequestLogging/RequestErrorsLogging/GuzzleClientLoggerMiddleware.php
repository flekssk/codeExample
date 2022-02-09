<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\DTO\RequestLogRecord;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\Services\BodyStreamReader;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\Services\SimpleIntegerPartsPathParamsParser;

//phpcs:disable SlevomatCodingStandard.Classes.ClassStructure.IncorrectGroupOrder --временно, до первой правки стиля файла
class GuzzleClientLoggerMiddleware
{
    private LoggerInterface $logger;

    private string $serviceDestAlias;

    private string $serviceSourceAlias;

    public function __construct(LoggerInterface $logger, string $serviceDestAlias, string $serviceSourceAlias)
    {
        $this->logger = $logger;
        $this->serviceDestAlias = $serviceDestAlias;
        $this->serviceSourceAlias = $serviceSourceAlias;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            /** @var PromiseInterface $promise */
            $promise = $handler($request, $options);

            return $promise->then(
                function (ResponseInterface $response) use ($request) {
                    if ($response->getStatusCode() !== Response::HTTP_OK) {
                        $this->logResponse($request, $response);
                    }

                    return $response;
                },
                function ($reason) use ($request) {
                    if ($reason instanceof RequestException && $reason->hasResponse()) {
                        $this->logResponse($request, $reason->getResponse());
                    } else {
                        $responseData = null;
                        $responseCode = 0;

                        if ($reason instanceof \Throwable) {
                            $responseData = $reason->getMessage();
                            $responseCode = $reason->getCode();
                        }

                        $this->doLog($request, (int)$responseCode, $responseData);
                    }

                    return \GuzzleHttp\Promise\rejection_for($reason);
                }
            );
        };
    }

    private function doLog(RequestInterface $request, int $responseCode, ?string $responseData): void
    {
        $paramsParser = new SimpleIntegerPartsPathParamsParser();
        $parsedRequestParams = $paramsParser->parseRequest($request);
        $msg = new RequestLogRecord(
            $this->serviceDestAlias,
            $this->serviceSourceAlias,
            $parsedRequestParams->endpoint(),
            $request->getMethod(),
            $parsedRequestParams->params(),
            $responseCode,
            $responseData
        );

        $this->logger->warning('API call error', ['requestInfo' => $msg]);
    }

    private function logResponse(RequestInterface $request, ResponseInterface $response): void
    {
        $this->doLog(
            $request,
            $response->getStatusCode(),
            $this->getDataForResponse($response)
        );
    }

    private function getDataForResponse(ResponseInterface $response): ?string
    {
        return BodyStreamReader::readBodyForLogging($response->getBody());
    }
}
