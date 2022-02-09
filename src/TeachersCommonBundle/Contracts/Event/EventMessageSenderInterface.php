<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Contracts\Event;

use TeachersCommonBundle\Feature\ConventionalResponse\Exception\TeachersCommonException;

interface EventMessageSenderInterface
{
    /**
     * @throws TeachersCommonException
     */
    public function send(EventEnvelopeInterface $envelope): void;
}
