<?php

declare(strict_types=1);

namespace App\Infrastructure\EventDispatcher;

use App\Domain\EventDispatcher\EventDispatcherInterface;
use App\Domain\EventDispatcher\ListenerProviderInterface;
use App\Domain\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var ListenerProviderInterface
     */
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @inheritdoc
     */
    public function dispatch($event)
    {
        if ($listeners = $this->listenerProvider->getListenersForEvent($event)) {
            return $this->doDispatch($listeners, $event);
        }
        return $event;
    }

    /**
     * @inheritDoc
     */
    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    /**
     * @param iterable $listeners
     * @param object $event
     * @return object
     */
    protected function doDispatch(iterable $listeners, $event)
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
            $listener($event);
        }

        return $event;
    }
}
