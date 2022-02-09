<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

use Symfony\Component\HttpFoundation\Request;

interface RequesterNameProviderInterface
{
    public function getName(Request $request): string;
}
