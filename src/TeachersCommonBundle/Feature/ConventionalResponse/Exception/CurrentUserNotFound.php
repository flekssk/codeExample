<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDetailsDTO;

class CurrentUserNotFound extends \Exception implements ConventionalResponseExceptionInterface
{
    public function __construct(?string $customMessage = null)
    {
        $message = $customMessage ?? 'Current user not found.';

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
