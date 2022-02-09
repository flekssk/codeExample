<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\EventListener;

use Symfony\Component\HttpKernel\Event\ViewEvent;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\Service\ConventionalResponseBuilder;

final class ConventionalResponseEventListener
{
    private ConventionalResponseBuilder $responseBuilder;

    public function __construct(ConventionalResponseBuilder $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }

    public function onKernelView(ViewEvent $event): void
    {
        $value = $event->getControllerResult();

        if ($value instanceof ConventionalApiResponseDTO) {
            $event->setResponse(
                $this->responseBuilder->response($value)
            );
        }
    }
}
