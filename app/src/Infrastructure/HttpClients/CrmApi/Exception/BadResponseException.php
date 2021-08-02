<?php

namespace App\Infrastructure\HttpClients\CrmApi\Exception;

use Psr\Http\Client\ClientExceptionInterface;

class BadResponseException extends \RuntimeException implements ClientExceptionInterface
{
}
