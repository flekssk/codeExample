<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestQualityLogging;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestQualityLogging\Services\QualityReporter;

//phpcs:disable SlevomatCodingStandard.Classes.ClassStructure.IncorrectGroupOrder --временно, до первой правки стиля файла
class GuzzleClientRequestReporterMiddleware
{
    private QualityReporter $qualityReporter;

    private string $serviceDestAlias;

    public function __construct(QualityReporter $qualityReporter, string $serviceDestAlias)
    {
        $this->qualityReporter = $qualityReporter;
        $this->serviceDestAlias = $serviceDestAlias;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            /** @var PromiseInterface $promise */
            $promise = $handler($request, $options);

            return $promise->then(
                function (ResponseInterface $response) {
                    $this->reportForResponse($response);

                    return $response;
                },
                function ($reason) {
                    if ($reason instanceof RequestException && $reason->hasResponse()) {
                        $this->reportForResponse($reason->getResponse());
                    } else {
                        $this->qualityReporter->reportFail($this->serviceDestAlias);
                    }

                    return \GuzzleHttp\Promise\rejection_for($reason);
                }
            );
        };
    }

    private function reportForResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() < Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->qualityReporter->reportSuccess($this->serviceDestAlias);
        } else {
            $this->qualityReporter->reportFail($this->serviceDestAlias);
        }
    }
}
