<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Filter;

use Opis\JsonSchema\IFilter;

class DummyNullFilter implements IFilter
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function validate($data, array $args): bool
    {
        return true;
    }
}
