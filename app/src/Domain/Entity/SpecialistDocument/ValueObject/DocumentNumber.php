<?php

namespace App\Domain\Entity\SpecialistDocument\ValueObject;

use DomainException;

/**
 * Class DocumentNumber.
 *
 * @package App\Domain\Entity\Specialist\ValueObject
 */
class DocumentNumber
{
    /**
     * Соответствует "У12345", "Д12345", "А12345".
     */
    private const NUMBER_PATTERN = '/^(У|Д|А)(\d*)$/';

    /**
     * Полный номер документа, например "У12345".
     *
     * @var string
     */
    private string $value;

    /**
     * Соответствует букве, означающей тип документа (А-аттестат, Д-диплом, У-удостоверение), например "У", в "У12345".
     *
     * @var string|null
     */
    private ?string $type = '';

    /**
     * Соответствует номеру документа, например "12345", в "У12345".
     *
     * @var string|null
     */
    private ?string $number = '';

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * DocumentNumber constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new DomainException(sprintf('Значение для DocumentNumber не может быть пустым.'));
        }

        // Проверка на совпадение с паттерном.
        $matches = [];
        $valid = preg_match(self::NUMBER_PATTERN, $value, $matches);
        if ($valid) {
            $this->value = $value;
            $this->type = $matches[1];
            $this->number = $matches[2];
        } else {
            $this->value = $value;
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
