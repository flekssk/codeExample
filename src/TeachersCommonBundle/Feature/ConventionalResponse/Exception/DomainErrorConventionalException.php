<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDetailsDTO;

class DomainErrorConventionalException extends \Exception implements ConventionalResponseExceptionInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function getConventionalCode(): string
    {
        return ConventionalResponseErrorDetailsDTO::CODE_DOMAIN_ERROR;
    }

    public function getProperty(): ?string
    {
        return null;
    }

    public function getExtra(): ?\stdClass
    {
        return null;
    }
}
