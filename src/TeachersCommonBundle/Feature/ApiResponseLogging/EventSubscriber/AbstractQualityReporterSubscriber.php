<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\ApiResponseQualityReporter;
use TeachersCommonBundle\Feature\ApiResponseLogging\Service\MethodNameProviderInterface;

abstract class AbstractQualityReporterSubscriber implements EventSubscriberInterface
{
    protected MethodNameProviderInterface $methodNameProvider;
    private ApiResponseQualityReporter $qualityReporter;

    abstract protected function isApplicable(Request $request): bool;

    abstract protected function getRequesterName(Request $request): string;

    public function __construct(
        MethodNameProviderInterface $methodNameProvider,
        ApiResponseQualityReporter $qualityReporter
    ) {
        $this->methodNameProvider = $methodNameProvider;
        $this->qualityReporter = $qualityReporter;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            // будем логировать только авторизованных пользователей
            return;
        }

        if ($response->getStatusCode() === Response::HTTP_MOVED_PERMANENTLY) {
            // не будем логировать редиректы, которые Symfony автоматом возвращает на URI с trailing slash
            return;
        }

        $request = $event->getRequest();

        if (!$this->isApplicable($request)) {
            return;
        }

        $methodName = $this->getMethodName($request);

        if ($methodName === '') {
            return;
        }

        $requesterName = $this->getRequesterName($request);

        if ($requesterName === '') {
            return;
        }

        $responseContent = json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        if (
            ($response->getStatusCode() !== Response::HTTP_OK) ||
            (isset($responseContent['errors']) && count($responseContent['errors']) > 0)
        ) {
            $this->qualityReporter->reportError($requesterName, $methodName);

            return;
        }

        $this->qualityReporter->reportSuccess($requesterName, $methodName);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    protected function getMethodName(Request $request): string
    {
        return $this->methodNameProvider->getName($this->prepareUriForQualityReporter($request));
    }

    protected function prepareUriForQualityReporter(Request $request): string
    {
        $uri = $request->getPathInfo();

        if (
            !$request->attributes->has('qualityReporterUriMask')
            || !preg_match($request->attributes->get('qualityReporterUriMask'), $uri, $matches)
        ) {
            return $uri;
        }

        return $matches[1];
    }
}
