<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\ApiResponseQualityReporter;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\MethodNameProviderInterface;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\RequestOriginBeautifier;

abstract class AbstractClientApiQualityReporterSubscriber extends AbstractQualityReporterSubscriber
{
    private RequestOriginBeautifier $originBeautifier;

    public function __construct(
        RequestOriginBeautifier $originBeautifier,
        MethodNameProviderInterface $methodNameProvider,
        ApiResponseQualityReporter $qualityReporter
    ) {
        parent::__construct($methodNameProvider, $qualityReporter);

        $this->originBeautifier = $originBeautifier;
    }

    protected function getRequesterName(Request $request): string
    {
        return $this->originBeautifier->beautify(
            $request->headers->get('origin')
        );
    }

    protected function getMethodName(Request $request): string
    {
        return 'client_api' . parent::getMethodName($request);
    }
}
