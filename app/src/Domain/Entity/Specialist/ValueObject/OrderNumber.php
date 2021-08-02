<?php

namespace App\Domain\Entity\Specialist\ValueObject;

use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;
use DateTimeImmutable;
use DomainException;

/**
 * Class OrderNumber.
 *
 * @package App\Domain\Entity\Specialist\ValueObject
 */
class OrderNumber
{
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
     * Number constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new DomainException(sprintf('Значение для Number не может быть пустым.'));
        }

        $this->value = $value;
    }

    /**
     * @param DateTimeImmutable $date
     * @param int               $specialistId
     *
     * @return OrderNumber
     */
    public static function createFromDateAndSpecialistId(DateTimeImmutable $date, int $specialistId): OrderNumber
    {
        $dateValue = $date->format('Y-m-d');

        return new OrderNumber("Р-{$dateValue}-{$specialistId}");
    }

    /**
     * @param DateTimeImmutable $date
     * @param DocumentNumber $documentNumber
     * @param int $lastOrderId
     *
     * @return OrderNumber
     */
    public static function createNumberForIssueOfADocumentOrder(DateTimeImmutable $date, DocumentNumber $documentNumber, int $lastOrderId): OrderNumber
    {
        $documentType = $documentNumber->getType() ?: '';
        $dateValue = $date->format('Y-m-d');
        $lastOrderId += 1;

        $parts = [$dateValue, $lastOrderId];

        if (!empty($documentType)) {
            array_unshift($parts, $documentType);
        }

        return new OrderNumber(implode('-', $parts));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
