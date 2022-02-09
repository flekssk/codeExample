<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestQualityLogging\Services;

use Domnikl\Statsd\Client as StatsdClient;

class QualityReporter
{
    private StatsdClient $statsdClient;

    public function __construct(StatsdClient $statsdClient)
    {
        $this->statsdClient = $statsdClient;
    }

    public function reportSuccess(string $serviceName): void
    {
        if (\strlen($serviceName) === 0) {
            return;
        }

        $this->statsdClient->increment(
            $this->getMetricName($serviceName, 'success')
        );
    }

    public function reportFail(string $serviceName): void
    {
        if (\strlen($serviceName) === 0) {
            return;
        }

        $this->statsdClient->increment(
            $this->getMetricName($serviceName, 'fail')
        );
    }

    private function getMetricName(string $serviceName, string $eventName): string
    {
        return \sprintf('quality.requests.%s.%s.count', $serviceName, $eventName);
    }
}
