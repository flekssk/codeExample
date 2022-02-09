<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\RabbitSender\Service;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use TeachersCommonBundle\Contracts\Event\EventEnvelopeInterface;
use TeachersCommonBundle\Feature\RabbitSender\Exception\RabbitSenderRoutingException;

class RabbitProducerProvider
{
    /**
     * @var iterable|ProducerInterface[]
     */
    private iterable $producers;

    /**
     * @param iterable|ProducerInterface[] $producers
     */
    public function __construct(iterable $producers)
    {
        $this->producers = $producers;
    }

    /**
     * @throws RabbitSenderRoutingException
     */
    public function getProducer(EventEnvelopeInterface $envelope): ProducerInterface
    {
        foreach ($this->producers as $producer) {
            if ($envelope->supports($producer)) {
                return $producer;
            }
        }

        throw new RabbitSenderRoutingException(
            sprintf('No producer found for event envelope [%s]', get_class($envelope))
        );
    }
}
