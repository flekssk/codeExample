<?php

namespace TeachersTrainingCenterBundle\RabbitMq\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use OldSound\RabbitMqBundle\Event\BeforeProcessingMessageEvent;
use OldSound\RabbitMqBundle\Event\AfterProcessingMessageEvent;

class NewRelicAMQPSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeProcessingMessageEvent::NAME => ['beforeMessage'],
            AfterProcessingMessageEvent::NAME => ['afterMessage'],
        ];
    }

    public function beforeMessage(BeforeProcessingMessageEvent $event)
    {
        if (extension_loaded('newrelic')) {
            newrelic_start_transaction('ttc api');
            newrelic_name_transaction('Tasks/' . $this->generateTaskNameFromCommandLineArguments());
        }
    }

    public function afterMessage(AfterProcessingMessageEvent $event)
    {
        if (extension_loaded('newrelic')) {
            newrelic_end_transaction();
        }
    }

    /**
     * Transforms console command like
     * php bin/console rabbitmq:consumer -m 10 rooms.event.rooms.lesson.ended --env=dev -vv
     * into readable newrelic task name rabbitmq:consumer__rooms.event.rooms.lesson.ended
     */
    private function generateTaskNameFromCommandLineArguments(): string
    {
        if (empty($_SERVER['argv'])) {
            return 'unknown';
        }

        return implode(
            '__',
            array_filter($_SERVER['argv'], function ($arg) {
                return !is_numeric($arg) && is_string($arg) && strpos($arg, '-') !== 0 && strpos($arg, '/') !== 0;
            }),
        );
    }
}
