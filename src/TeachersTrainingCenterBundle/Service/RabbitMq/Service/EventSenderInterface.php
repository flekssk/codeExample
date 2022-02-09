<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service\RabbitMq\Service;

interface EventSenderInterface
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function send($event, string $routingKey = ''): void;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function sendSilently($event, string $routingKey = ''): void;
}
