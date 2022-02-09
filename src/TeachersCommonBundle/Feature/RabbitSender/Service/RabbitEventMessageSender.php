<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\RabbitSender\Service;

use JMS\Serializer\SerializerInterface;
use TeachersCommonBundle\Contracts\Event\EventEnvelopeInterface;
use TeachersCommonBundle\Contracts\Event\EventMessageSenderInterface;
use TeachersCommonBundle\Feature\RabbitSender\Exception\RabbitSenderRoutingException;
use TeachersCommonBundle\Feature\RabbitSender\Exception\RabbitSenderTransportException;

class RabbitEventMessageSender implements EventMessageSenderInterface
{
    private RabbitProducerProvider $producerProvider;
    private SerializerInterface $serializer;

    public function __construct(RabbitProducerProvider $producerProvider, SerializerInterface $serializer)
    {
        $this->producerProvider = $producerProvider;
        $this->serializer = $serializer;
    }

    /**
     * @throws RabbitSenderTransportException
     * @throws RabbitSenderRoutingException
     */
    public function send(EventEnvelopeInterface $envelope): void
    {
        $producer = $this->producerProvider->getProducer($envelope);
        $messageBody = $this->serializer->serialize($envelope->getEvent(), 'json');

        try {
            $producer->publish($messageBody, $envelope->getRoutingKey());
        } catch (\Throwable $e) {
            throw new RabbitSenderTransportException($e->getMessage());
        }
    }
}
