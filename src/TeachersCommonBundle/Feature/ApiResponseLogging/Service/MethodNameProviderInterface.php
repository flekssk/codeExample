<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

interface MethodNameProviderInterface
{
    public function getName(string $uri, string $rootUri = ''): string;
}
