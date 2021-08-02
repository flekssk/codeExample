<?php

declare(strict_types=1);

namespace App\Domain\Entity\SpecialistAccess;

use DateTimeInterface;

/**
 * Class SpecialistAccess.
 *
 * @package App\Domain\Entity\SpecialistAccess
 */
class SpecialistAccess
{
    /**
     * Id
     *
     * @var int
     */
    private int $id;

    /**
     * Id пользователя в id2.
     *
     * @var int
     */
    private int $specialistId;

    /**
     * Id продукта.
     *
     * @var int
     */
    private int $productId;

    /**
     * Дата начала доступа.
     *
     * @var DateTimeInterface
     */
    private DateTimeInterface $dateStart;

    /**
     * Дата окончания доступа.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $dateEnd;

    /**
     * @return int
     * @ignore Getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @ignore Setter
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     * @ignore Getter
     */
    public function getSpecialistId(): int
    {
        return $this->specialistId;
    }

    /**
     * @param int $specialistId
     * @ignore Setter
     */
    public function setSpecialistId(int $specialistId): void
    {
        $this->specialistId = $specialistId;
    }

    /**
     * @return int
     * @ignore Getter
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @ignore Setter
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return DateTimeInterface
     * @ignore Getter
     */
    public function getDateStart(): DateTimeInterface
    {
        return $this->dateStart;
    }

    /**
     * @param DateTimeInterface $dateStart
     * @ignore Setter
     */
    public function setDateStart(DateTimeInterface $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return DateTimeInterface|null
     * @ignore Getter
     */
    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    /**
     * @param DateTimeInterface|null $dateEnd
     * @ignore Setter
     */
    public function setDateEnd(?DateTimeInterface $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }
}
