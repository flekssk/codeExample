<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClients;

use GuzzleHttp\Psr7\Uri;

trait UriTrait
{
    /**
     * Возвращает url путь до endpoint api.
     *
     * @param string $endpointPath
     *
     * @param array  $queryParams
     *
     * @return Uri
     */
    protected function resolveEndpointUri(string $endpointPath, array $queryParams = []): Uri
    {
        $uri = new Uri($this->apiUrl);

        $uri = $uri->withPath($endpointPath);

        if (count($queryParams)) {
            $queryParamValues = [];
            foreach ($queryParams as $queryParamName => $queryParamValue) {
                $queryParamValues[] = $queryParamName . '=' . $queryParamValue;
            }

            $uri = $uri->withQuery(implode('&', $queryParamValues));
        }

        return $uri;
    }
}
