<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Filter;

use Opis\JsonSchema\IFilter;

class CheckTimeWithTimezoneFormatFilter implements IFilter
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function validate($data, array $args): bool
    {
        $value = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, '2001-01-01T' . $data);

        if ($value === false) {
            return false;
        }

        $errors = \DateTimeImmutable::getLastErrors();
        $totalErrorsCount = ($errors['warning_count'] ?? 0) + ($errors['error_count'] ?? 0);

        return $totalErrorsCount === 0;
    }
}
