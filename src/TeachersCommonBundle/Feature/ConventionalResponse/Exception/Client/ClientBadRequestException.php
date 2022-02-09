<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client;

final class ClientBadRequestException extends ClientException
{
    protected static function buildMessage(string $serviceName, string $uri, int $code): string
    {
        return sprintf('Bad request from %s method [%s], code [%d]', $serviceName, $uri, $code);
    }
}
