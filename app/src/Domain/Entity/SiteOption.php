<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeInterface;

/**
 * Class SiteOption.
 *
 * Сущность опции ресурса.
 */
class SiteOption
{
    /**
     * @var int|null
     */
    private ?int $id = 0;

    /**
     * Уникальное имя опции.
     *
     * @var string
     */
    private string $name;

    /**
     * Значение.
     *
     * @var string|null
     */
    private ?string $value = '';

    /**
     * Описание.
     *
     * @var string|null
     */
    private ?string $description = '';

    /**
     * Дата создания.
     *
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * Дата обновления.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * SiteOption constructor.
     *
     * @param string $name
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeInterface|null
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
