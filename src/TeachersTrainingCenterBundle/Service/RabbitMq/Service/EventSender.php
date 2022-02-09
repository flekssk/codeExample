<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service\RabbitMq\Service;

use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersTrainingCenterBundle\Service\RabbitMq\Exception\RabbitEventException;

class EventSender implements EventSenderInterface
{
    private ProducerProviderInterface $producerProvider;

    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    private LoggerInterface $logger;

    public function __construct(
        ProducerProviderInterface $producerProvider,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->producerProvider = $producerProvider;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param $event
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function sendSilently($event, string $routingKey = ''): void
    {
        try {
            $this->send($event, $routingKey);
        } catch (\Throwable $e) {
            $this->logger->error(
                \sprintf('Не удалось отправить событие %s', getClass($event)),
                [
                    'exception' => $e,
                    'event' => $event,
                ]
            );
        }
    }

    /**
     * @param $event
     *
     * @throws RabbitEventException
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function send($event, string $routingKey = ''): void
    {
        $this->validate($event);

        $producers = $this->producerProvider->getProducers(getClass($event));

        $msgBody = $this->getMessage($event);

        $errors = [];

        foreach ($producers as $producer) {
            try {
                $producer->publish($msgBody, $routingKey);
            } catch (\Throwable $e) {
                array_push(
                    $errors,
                    sprintf('Error on sending message to [%s] producer: [%s]', getClass($producer), $e->getMessage())
                );
            }
        }

        if ($errors !== []) {
            throw new RabbitEventException(implode('; ', $errors));
        }
    }

    /**
     * @param object $event
     *
     * @throws RabbitEventException
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    protected function validate($event): void
    {
        $errors = $this->validator->validate($event);

        if (count($errors) === 0) {
            return;
        }

        $errorMessages = [];

        foreach ($errors as $e) {
            array_push($errorMessages, sprintf('[%s]: %s', $e->getPropertyPath(), $e->getMessage()));
        }

        throw new RabbitEventException(sprintf(
            'Error(s) on [%s] event object validation: %s',
            getClass($event),
            implode(' ', $errorMessages)
        ));
    }

    /**
     * @param $event
     *
     * @return string
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    protected function getMessage($event): string
    {
        return $this->serializer->serialize($event, 'json');
    }
}
