<?php

declare(strict_types=1);

namespace App\Domain\Entity\ValueObject;

use JsonSerializable;

/**
 * Class Gender.
 *
 * Объект пола, 0 - женский, 1 - мужской, 2 - не определён.
 *
 * @package App\Domain\Entity\ValueObject
 */
class Gender implements JsonSerializable
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Gender constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        if ($value < 0 || $value > 2) {
            throw new \DomainException(sprintf('Wrong gender value "%s" allowed 0 or 1 or 2', $value));
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @param Gender $gender
     *
     * @return bool
     */
    public function isEqual(Gender $gender): bool
    {
        return (string) $this->value === (string) $gender;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->getValue() === 0) {
            return 'Женский';
        } else if ($this->getValue() === 1) {
            return 'Мужской';
        } else {
            return 'Не определён';
        }
    }
}
