<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\QualityReporter\Service;

use Domnikl\Statsd\Client as StatsdClient;

class QualityReporter
{
    private StatsdClient $statsdClient;

    public function __construct(StatsdClient $statsdClient)
    {
        $this->statsdClient = $statsdClient;
    }

    public function reportEvent(string $eventName): void
    {
        $this->statsdClient->increment(sprintf('quality.%s.count', $eventName));
    }

    public function reportGauge(string $gaugeName, int $gaugeValue): void
    {
        $this->statsdClient->gauge(
            sprintf('quality.%s.gauge', $gaugeName),
            $gaugeValue
        );
    }
}
