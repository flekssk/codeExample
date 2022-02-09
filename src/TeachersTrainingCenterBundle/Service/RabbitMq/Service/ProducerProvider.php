<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service\RabbitMq\Service;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use TeachersTrainingCenterBundle\Service\RabbitMq\Exception\RabbitEventException;

//phpcs:disable SlevomatCodingStandard.Classes.ClassStructure.IncorrectGroupOrder --временно, до первой правки стиля файла
class ProducerProvider implements ProducerProviderInterface
{
    /**
     * @var ProducerInterface[][]
     */
    private array $producersVsEvents = [];

    public function registerEvent(string $eventClass, ProducerInterface $producer): void
    {
        $eventProducers = $this->producersVsEvents[$eventClass] ?? [];

        if (\in_array($producer, $eventProducers, true)) {
            return;
        }

        $this->producersVsEvents[$eventClass][] = $producer;
    }

    /**
     * @return ProducerInterface[]
     *
     * @throws RabbitEventException
     */
    public function getProducers(string $eventClass): array
    {
        if (!\array_key_exists($eventClass, $this->producersVsEvents)) {
            throw new RabbitEventException(sprintf('No producers found for event class [%s]', $eventClass));
        }

        return $this->producersVsEvents[$eventClass];
    }
}
