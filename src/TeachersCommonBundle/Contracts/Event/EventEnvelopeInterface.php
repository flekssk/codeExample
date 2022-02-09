<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Contracts\Event;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

interface EventEnvelopeInterface
{
    public function supports(ProducerInterface $producer): bool;

    public function getRoutingKey(): string;

    public function getEvent(): EventInterface;
}
