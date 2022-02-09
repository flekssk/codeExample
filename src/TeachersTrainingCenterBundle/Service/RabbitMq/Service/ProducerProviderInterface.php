<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service\RabbitMq\Service;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

interface ProducerProviderInterface
{
    /**
     * @return ProducerInterface[]
     */
    public function getProducers(string $eventClass): array;
}
