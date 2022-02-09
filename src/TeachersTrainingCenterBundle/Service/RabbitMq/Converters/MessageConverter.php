<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service\RabbitMq\Converters;

use JMS\Serializer\SerializerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersTrainingCenterBundle\Service\RabbitMq\Events\AMQPEvent;

class MessageConverter
{
    private LoggerInterface $logger;

    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    public function __construct(
        LoggerInterface $logger,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function convert(AMQPMessage $msg, string $eventName): ?AMQPEvent
    {
        $this->throwIfNotSupported($eventName);

        $event = null;

        try {
            $this->logger->debug(sprintf('Incoming message: [%s]', $msg->getBody()));

            /** @var AMQPEvent $event */
            $event = $this->serializer->deserialize($msg->getBody(), $eventName, 'json');

            $errors = $this->validator->validate($event);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $errors = ['Unable to decode JSON'];
        }

        if (count($errors) > 0) {
            $this->logger->error(
                sprintf('Некорректный формат сообщения: [%s]', $msg->getBody()),
                ['errors' => $errors]
            );

            return null;
        }

        return $event;
    }

    private function throwIfNotSupported(string $eventName): void
    {
        try {
            $reflect = new \ReflectionClass($eventName);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Передан несуществующий эвент для десериализации, проверьте правильность имени класса'
            );
        }

        if ($reflect->implementsInterface(AMQPEvent::class) === false) {
            throw new \RuntimeException(
                'Неверный тип эвента для конвертирования, из AMQPMessage'
            );
        }
    }
}
