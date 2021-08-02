<?php

namespace App\Domain\Entity\ReferenceInformation;

/**
 * Class ReferenceInformation.
 *
 * Сущность "Ссылки на нормативно-справочную информацию
 *
 * @package App\Domain\Entity\ReferenceInformation
 */
class ReferenceInformation
{
    /**
     * ID записи
     *
     * @var int
     */
    private ?int $id = 0;

    /**
     * Ссылка
     *
     * @var string
     */
    private string $url = '';

    /**
     * Название
     *
     * @var string
     */
    private string $title = '';

    /**
     * Активность
     *
     * @var bool
     */
    private bool $active = true;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id ?? 0;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
