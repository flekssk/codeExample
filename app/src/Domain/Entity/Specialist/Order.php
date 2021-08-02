<?php

namespace App\Domain\Entity\Specialist;

use DateTimeInterface;
use App\Domain\Entity\Specialist\ValueObject\OrderNumber;
use App\Domain\Entity\Specialist\ValueObject\OrderType;
use Doctrine\Common\Collections\Collection;

/**
 * Class Order.
 *
 * @package App\Domain\Entity\Specialist
 */
class Order
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $number;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $date;

    /**
     * @var Collection
     */
    private Collection $specialists;

    /**
     * @var string|null
     */
    private ?string $templateId;

    /**
     * Order constructor.
     *
     * @param OrderNumber $number
     * @param OrderType $type
     * @param DateTimeInterface $date
     * @param Collection $specialists
     * @param string|null $templateId
     */
    public function __construct(
        OrderNumber $number,
        OrderType $type,
        DateTimeInterface $date,
        Collection $specialists,
        string $templateId = null
    ) {
        $this->number = $number->getValue();
        $this->type = $type->getValue();
        $this->date = $date;
        $this->specialists = $specialists;
        $this->templateId = $templateId;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return Collection
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getSpecialists(): Collection
    {
        return $this->specialists;
    }

    /**
     * @return OrderNumber
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getNumber(): OrderNumber
    {
        return new OrderNumber($this->number);
    }

    /**
     * @return OrderType
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getType(): OrderType
    {
        return new OrderType($this->type);
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }
}
