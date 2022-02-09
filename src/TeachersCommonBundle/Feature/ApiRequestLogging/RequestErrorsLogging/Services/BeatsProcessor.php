<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\Services;

use TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\DTO\RequestLogRecord;

class BeatsProcessor
{
    /**
     * @param array $record
     *
     * @return array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function __invoke(array $record): array
    {
        $requestInfo = $record['context']['requestInfo'] ?? null;

        if (!$requestInfo instanceof RequestLogRecord) {
            return $record;
        }

        $record['context'] = array_merge($record['context'], $requestInfo->asArray());

        unset($record['context']['requestInfo']);

        return $record;
    }
}
