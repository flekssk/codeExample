<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Model\Enum;

use JMS\Serializer\Annotation as JMS;
use TeachersTrainingCenterBundle\Exception\InvalidStringEnumException;

abstract class AbstractStringEnum
{
    /**
     * @JMS\Type("string")
     */
    protected string $value;

    /**
     * @return string[]
     */
    abstract protected static function allValues(): array;

    abstract protected function fallbackValue(): ?string;

    public function __construct(string $value)
    {
        $fallbackOrProvidedValue = \in_array($value, static::allValues(), true) ? $value : $this->fallbackValue();

        if ($fallbackOrProvidedValue === null) {
            throw InvalidStringEnumException::wrongEnumValue($value, static::allValues());
        }

        $this->value = $fallbackOrProvidedValue;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string[] $values
     *
     * @return static[]
     */
    public static function createListForValues(array $values): array
    {
        return \array_map(static fn ($type) => new static($type), \array_unique($values));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
