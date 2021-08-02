<?php

declare(strict_types=1);

namespace App\Domain\EventDispatcher;

interface ListenerProviderInterface
{
    /**
     * @param object $event
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable;
}
