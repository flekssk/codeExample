<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

class MethodNameProvider implements MethodNameProviderInterface
{
    public function getName(string $uri, string $rootUri = ''): string
    {
        return str_replace(
            '/',
            '_',
            $this->stripUri($uri, $rootUri)
        );
    }

    private function stripUri(string $uri, string $root): string
    {
        if ($root !== '' && stripos($uri, $root) !== 0) {
            return $uri;
        }

        $uriWithoutPrefix = substr($uri, strlen($root));

        if ($uriWithoutPrefix === '' || $uriWithoutPrefix === '/') {
            return '/';
        }

        return substr($uriWithoutPrefix, -1) === '/'
            ? substr($uriWithoutPrefix, 0, -1)
            : $uriWithoutPrefix;
    }
}
