<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Skyeng\LogBundle\SimpleLoggerAwareTrait;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Event\CourseAssignmentEvent;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Service\CourseAssignmentEventHandler;
use TeachersTrainingCenterBundle\Service\RabbitMq\Converters\MessageConverter;

class CourseAssignmentConsumer implements ConsumerInterface
{
    use SimpleLoggerAwareTrait;

    private CourseAssignmentEventHandler $handler;

    private MessageConverter $converter;

    public function __construct(CourseAssignmentEventHandler $handler, MessageConverter $converter)
    {
        $this->handler = $handler;
        $this->converter = $converter;
    }

    public function execute(AMQPMessage $msg): int
    {
        $event = $this->converter->convert($msg, CourseAssignmentEvent::class);

        if ($event === null) {
            return self::MSG_ACK;
        }

        try {
            $this->handler->handleMessage($event);

            $this->logger->debug('Done.');
        } catch (\Throwable $exception) {
            $this->logger->error(
                'Error with handling message for ' . self::class,
                [
                    'msgBody' => $msg->getBody(),
                    'exception' => $exception,
                ]
            );

            return self::MSG_REJECT_REQUEUE;
        }

        return self::MSG_ACK;
    }
}
