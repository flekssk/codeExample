<?php

declare(strict_types=1);

namespace App\Domain\EventDispatcher;

interface EventDispatcherInterface
{
    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event);

    /**
     * @param object[] $events
     * @return void
     */
    public function dispatchAll(array $events): void;
}
