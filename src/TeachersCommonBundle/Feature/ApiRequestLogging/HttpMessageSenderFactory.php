<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging;

use Psr\Http\Client\ClientInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\Service\HttpMessageSender;

final class HttpMessageSenderFactory
{
    private GuzzleClientFactory $clientFactory;

    public function __construct(GuzzleClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function createLoggedSender(string $serviceDestAlias, array $config = []): HttpMessageSender
    {
        /** @var ClientInterface $client */
        $client = $this->clientFactory->createLoggedClient($serviceDestAlias, $config);

        return new HttpMessageSender($client, $serviceDestAlias);
    }
}
