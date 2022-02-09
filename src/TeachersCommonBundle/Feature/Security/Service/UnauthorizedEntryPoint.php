<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\Security\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class UnauthorizedEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * {@inheritdoc}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return new JsonResponse(
            [
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
