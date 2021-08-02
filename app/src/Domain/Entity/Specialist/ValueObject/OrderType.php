<?php

namespace App\Domain\Entity\Specialist\ValueObject;

use DomainException;

/**
 * Class Type.
 *
 * @package App\Domain\Entity\Specialist\ValueObject
 */
class OrderType
{
    /**
     * Соответствует типу "О включении в Реестр".
     */
    public const INCLUSION = 'inclusion';

    /**
     * Соответствует типу "О выдаче документа".
     */
    public const ISSUE_OF_A_DOCUMENT = 'issue_of_a_document';

    /**
     * Название типа приказа о включении.
     */
    public const INCLUSION_LABEL = 'Приказ о включении в Реестр';

    /**
     * Название типа приказа о выдаче документа.
     */
    public const ISSUE_OF_A_DOCUMENT_LABEL = 'Приказ о выдаче';

    /**
     * Массив с типами приказов.
     */
    public const TYPES = [
        self::INCLUSION,
        self::ISSUE_OF_A_DOCUMENT,
    ];

    /**
     * @var string
     */
    private string $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Type constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        if (!in_array($type, self::TYPES)) {
            throw new DomainException(
                sprintf(
                    'Тип приказа "%s" не существует. Доступные типы приказа: "%s" и "%s"',
                    $type,
                    self::INCLUSION,
                    self::ISSUE_OF_A_DOCUMENT
                )
            );
        }

        $this->value = $type;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
