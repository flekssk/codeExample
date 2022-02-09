<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\ApiResponseQualityReporter;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\MethodNameProviderInterface;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\RequesterNameProviderInterface;

abstract class AbstractServerApiQualityReporterSubscriber extends AbstractQualityReporterSubscriber
{
    private RequesterNameProviderInterface $requesterNameProvider;

    public function __construct(
        RequesterNameProviderInterface $requesterNameProvider,
        MethodNameProviderInterface $methodNameProvider,
        ApiResponseQualityReporter $qualityReporter
    ) {
        parent::__construct($methodNameProvider, $qualityReporter);

        $this->requesterNameProvider = $requesterNameProvider;
    }

    protected function getRequesterName(Request $request): string
    {
        return $this->requesterNameProvider->getName($request);
    }

    protected function getMethodName(Request $request): string
    {
        return 'server_api' . parent::getMethodName($request);
    }
}
