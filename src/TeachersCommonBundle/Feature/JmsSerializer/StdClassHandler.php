<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\JmsSerializer;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class StdClassHandler implements SubscribingHandlerInterface
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint*
     */
    public function serializeStdClassToJson(
        JsonSerializationVisitor $visitor,
        \stdClass $value,
        array $type,
        Context $context
    ) {
        return $value;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public function deserializeStdClassFromJson(
        JsonDeserializationVisitor $visitor,
        $value,
        array $type,
        Context $context
    ) {
        if ($value === []) {
            return new \stdClass();
        }

        return json_decode(
            json_encode($value, \JSON_THROW_ON_ERROR),
            false,
            512,
            \JSON_THROW_ON_ERROR
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     * @psalm-suppress InternalClass
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'stdClass',
                'method' => 'serializeStdClassToJson',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'stdClass',
                'method' => 'deserializeStdClassFromJson',
            ],
        ];
    }
}
