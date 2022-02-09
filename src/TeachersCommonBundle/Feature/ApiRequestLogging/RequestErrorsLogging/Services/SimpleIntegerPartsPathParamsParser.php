<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\Services;

use Psr\Http\Message\RequestInterface;
use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\DTO\RequestParsedPathParamsDTO;

class SimpleIntegerPartsPathParamsParser
{
    public function parseRequest(RequestInterface $request): RequestParsedPathParamsDTO
    {
        $uri = $request->getUri();

        ['endpoint' => $endpoint, 'pathData' => $requestData] = $this->parsePath($uri->getPath());

        if ($uri->getQuery() !== '') {
            $requestData['query'] = $uri->getQuery();
        }

        if ($request->getMethod() === 'POST') {
            $requestData['body'] = BodyStreamReader::readBodyForLogging($request->getBody());
        }

        return new RequestParsedPathParamsDTO($endpoint, $requestData);
    }

    /**
     * @return array = ['endpoint' => $endpoint, 'pathData' => $pathData]
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    private function parsePath(string $path): array
    {
        $parts = preg_split('/(\/)/i', $path, -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);

        $replaceItems = [];
        //phpcs:disable SlevomatCodingStandard.PHP.DisallowReference.DisallowedPassingByReference
        //phpcs:disable SlevomatCodingStandard.PHP.DisallowReference.DisallowedInheritingVariableByReference
        array_walk($parts, static function (&$part) use (&$replaceItems): void {
            if (is_numeric($part)) {
                $nextIndex = count($replaceItems);
                $replaceName = sprintf('{PATH_PARAM_%d}', $nextIndex);

                $replaceItems[$replaceName] = $part;
                $part = $replaceName;
            }
        });
        //phpcs:enable SlevomatCodingStandard.PHP.DisallowReference.DisallowedPassingByReference
        //phpcs:enable SlevomatCodingStandard.PHP.DisallowReference.DisallowedInheritingVariableByReference

        $endpoint = implode('', $parts);
        $pathData = $replaceItems;

        return ['endpoint' => $endpoint, 'pathData' => $pathData];
    }
}
