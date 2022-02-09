<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Skyeng\LogBundle\SimpleLoggerAwareTrait;
use Skyeng\RequestIdBundle\GuzzleHttp\RequestIdGuzzleHandler;
use Skyeng\RequestIdBundle\RequestIdServiceInterface;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\GuzzleClientLoggerMiddleware;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestQualityLogging\GuzzleClientRequestReporterMiddleware;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestQualityLogging\Services\QualityReporter;

class GuzzleClientFactory
{
    use SimpleLoggerAwareTrait;

    protected string $channel = 'external_api';

    private QualityReporter $qualityReporter;

    private string $serviceSourceAlias;

    private RequestIdServiceInterface $requestIdService;

    private int $defaultTimeout;

    private int $defaultConnectionTimeout;

    public function __construct(
        QualityReporter $qualityReporter,
        string $serviceSourceAlias,
        RequestIdServiceInterface $requestIdService,
        int $defaultTimeout,
        int $defaultConnectionTimeout
    ) {
        $this->qualityReporter = $qualityReporter;
        $this->serviceSourceAlias = $serviceSourceAlias;
        $this->requestIdService = $requestIdService;
        $this->defaultTimeout = $defaultTimeout;
        $this->defaultConnectionTimeout = $defaultConnectionTimeout;
    }

    /**
     * @param string $serviceDestAlias Алиас для сервиса, к которому ходим по http
     *                                 Фиксируем имя каждого нового сервиса для логирования здесь
     *                                 https://confluence.skyeng.tech/pages/viewpage.action?pageId=25407509
     * @param array $config
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function createLoggedClient(string $serviceDestAlias, array $config = []): Client
    {

        $stack = HandlerStack::create($config['handler'] ?? null);

        $stack->push(new GuzzleClientLoggerMiddleware($this->logger, $serviceDestAlias, $this->serviceSourceAlias));
        $stack->push(new GuzzleClientRequestReporterMiddleware($this->qualityReporter, $serviceDestAlias));

        $config['handler'] = $stack;

        if (!isset($config['connection_timeout'])) {
            $config['connection_timeout'] = $this->defaultConnectionTimeout;
        }

        if (!isset($config['timeout'])) {
            $config['timeout'] = $this->defaultTimeout;
        }

        $client = new Client($config);

        $handler = new RequestIdGuzzleHandler($this->requestIdService);
        $handler->addHandler($client);

        return $client;
    }
}
