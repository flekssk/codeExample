<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

interface ConventionalResponseExceptionInterface extends \Throwable
{
    public function getConventionalCode(): string;

    public function getProperty(): ?string;

    public function getExtra(): ?\stdClass;
}
