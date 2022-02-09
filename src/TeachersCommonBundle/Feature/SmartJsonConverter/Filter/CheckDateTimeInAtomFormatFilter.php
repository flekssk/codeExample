<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Filter;

use Opis\JsonSchema\IFilter;

class CheckDateTimeInAtomFormatFilter implements IFilter
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function validate($data, array $args): bool
    {
        $value = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $data);

        if ($value === false) {
            return false;
        }

        $errors = \DateTimeImmutable::getLastErrors();
        $totalErrorsCount = ($errors['warning_count'] ?? 0) + ($errors['error_count'] ?? 0);

        return $totalErrorsCount === 0;
    }
}
