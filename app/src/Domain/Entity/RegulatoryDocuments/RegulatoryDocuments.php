<?php

namespace App\Domain\Entity\RegulatoryDocuments;

use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class RegulatoryDocuments.
 *
 * Сущность "Ссылки на правовые документы".
 *
 * @Vich\Uploadable()
 *
 * @package App\Domain\Entity\RegulatoryDocuments
 */
class RegulatoryDocuments
{
    /**
     * ID записи.
     *
     * @var int
     */
    private ?int $id = 0;

    /**
     * Ссылка.
     *
     * @var string|null
     */
    private ?string $url = null;

    /**
     * Файл.
     *
     * @Vich\UploadableField(mapping="regulatory_documents_file", fileNameProperty="url")
     *
     * @var File|null
     */
    private ?File $file = null;

    /**
     * Название.
     *
     * @var string
     */
    private string $title = '';

    /**
     * Активность.
     *
     * @var bool
     */
    private bool $active = true;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt;

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
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
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

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
