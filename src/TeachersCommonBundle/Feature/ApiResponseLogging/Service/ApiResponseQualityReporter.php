<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

use TeachersCommonBundle\Feature\QualityReporter\Service\QualityReporter;

class ApiResponseQualityReporter
{
    private const SUCCESS_EVENT_NAME = 'success';
    private const ERROR_EVENT_NAME = 'error';

    private QualityReporter $qualityReporter;

    public function __construct(QualityReporter $qualityReporter)
    {
        $this->qualityReporter = $qualityReporter;
    }

    public function reportSuccess(string $requesterName, string $methodName): void
    {
        if (strlen($requesterName) === 0 || strlen($methodName) === 0) {
            return;
        }

        $this->qualityReporter->reportEvent(
            $this->getMetricName($requesterName, $methodName, self::SUCCESS_EVENT_NAME)
        );
    }

    public function reportError(string $requesterName, string $methodName): void
    {
        if (strlen($requesterName) === 0 || strlen($methodName) === 0) {
            return;
        }

        $this->qualityReporter->reportEvent(
            $this->getMetricName($requesterName, $methodName, self::ERROR_EVENT_NAME)
        );
    }

    private function getMetricName(string $requesterName, string $methodName, string $eventName): string
    {
        return sprintf('response_to.%s.%s.%s', $requesterName, $methodName, $eventName);
    }
}
