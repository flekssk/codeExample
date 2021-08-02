<?php

declare(strict_types=1);

namespace App\Domain\Entity\SpecialistExperience;

use DateTimeImmutable;

/**
 * Class SpecialistExperience.
 *
 * Сущность "Опыт работы".
 */
class SpecialistExperience
{
    /**
     * ID.
     *
     * @var int
     */
    private int $id;

    /**
     * ID пользователя.
     *
     * @var int
     */
    private int $specialistId;

    /**
     * Компания.
     *
     * @var string
     */
    private string $company;

    /**
     * Дата начала работы.
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $startDate;

    /**
     * Дата окончания работы.
     *
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $endDate;

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getSpecialistId(): int
    {
        return $this->specialistId;
    }

    /**
     * @param int $specialistId
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setSpecialistId(int $specialistId): void
    {
        $this->specialistId = $specialistId;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return DateTimeImmutable
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeImmutable $startDate
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTimeImmutable|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @param DateTimeImmutable|null $endDate
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setEndDate(?DateTimeImmutable $endDate): void
    {
        $this->endDate = $endDate;
    }
}
