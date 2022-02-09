<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Exception;

//phpcs:disable SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint

final class JMSSerializerRuntimeException extends \RuntimeException
{
    private ?string $property;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param $value
     *
     * @return self
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public static function invalidEnumConversion(string $property, $value, \Throwable $e): self
    {
        $self = new self($e->getMessage(), 0, $e);

        $self->value = $value;
        $self->property = $property;

        return $self;
    }

    /**
     * @param $value
     *
     * @return self
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    public static function invalidVOConversion(string $property, $value, \Throwable $e): self
    {
        $self = new self($e->getMessage(), 0, $e);

        $self->value = $value;
        $self->property = $property;

        return $self;
    }

    /**
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
