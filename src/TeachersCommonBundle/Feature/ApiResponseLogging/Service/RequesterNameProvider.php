<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

use Symfony\Component\HttpFoundation\Request;

class RequesterNameProvider implements RequesterNameProviderInterface
{
    public function getName(Request $request): string
    {
        $name = $request->headers->get('php-auth-user');

        return $name !== null && $name !== '' ? $name : 'UNKNOWN';
    }
}
