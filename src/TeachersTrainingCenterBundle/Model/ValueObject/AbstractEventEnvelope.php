<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Model\ValueObject;

use TeachersCommonBundle\Contracts\Event\EventEnvelopeInterface;
use TeachersCommonBundle\Contracts\Event\EventInterface;

abstract class AbstractEventEnvelope implements EventEnvelopeInterface
{
    private EventInterface $eventMessage;

    public function __construct(EventInterface $eventMessage)
    {
        $this->eventMessage = $eventMessage;
    }

    public function getRoutingKey(): string
    {
        return '';
    }

    public function getEvent(): EventInterface
    {
        return $this->eventMessage;
    }
}
