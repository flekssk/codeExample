<?php

declare(strict_types=1);

namespace App\Domain\EventDispatcher;

interface StoppableEventInterface
{
    /**
     * @return bool
     */
    public function isPropagationStopped() : bool;
}
