<?php

namespace App\Domain\Entity\DocumentType;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class DocumentType.
 *
 * @Vich\Uploadable
 *
 * @package App\Domain\Entity\DocumentType
 */
class DocumentType
{
    /**
     * ID.
     *
     * @var int
     */
    private int $id;

    /**
     * Название типа.
     *
     * @var string
     */
    private string $name;

    /**
     * Шаблон документа.
     *
     * @var DocumentTemplate
     */
    private DocumentTemplate $documentTemplate;

    /**
     * Название шаблона верстки.
     *
     * @var string
     */
    private string $templateName;

    /**
     * Флаг активности.
     *
     * @var bool
     */
    private bool $active;

    /**
     * URL изображения для превью.
     *
     * @var string|null
     */
    private ?string $imagePreview = '';

    /**
     * Файл изображения для превью.
     *
     * @Vich\UploadableField(mapping="document_type_preview", fileNameProperty="imagePreview")
     *
     * @var File|null
     */
    private ?File $imagePreviewFile = null;

    /**
     * URL изображения для фона.
     *
     * @var string|null
     */
    private ?string $imageBackground = '';

    /**
     * Файл изображения для фона.
     *
     * @Vich\UploadableField(mapping="document_type_background", fileNameProperty="imageBackground")
     *
     * @var File|null
     */
    private ?File $imageBackgroundFile = null;

    /**
     * Дата создания.
     *
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * Дата изменения.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * DocumentType constructor.
     *
     * @param int $id
     * @param string $name
     * @param DocumentTemplate $documentTemplate
     * @param string $templateName
     * @param bool $active
     * @param string|null $imagePreview
     * @param string|null $imageBackground
     * @param DateTimeInterface $createdAt
     * @param DateTimeInterface|null $updatedAt
     */
    public function __construct(
        int $id,
        string $name,
        DocumentTemplate $documentTemplate,
        string $templateName,
        bool $active,
        ?string $imagePreview,
        ?string $imageBackground,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->documentTemplate = $documentTemplate;
        $this->templateName = $templateName;
        $this->active = $active;
        $this->imagePreview = $imagePreview;
        $this->imageBackground = $imageBackground;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return DocumentTemplate
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getDocumentTemplate(): DocumentTemplate
    {
        return $this->documentTemplate;
    }

    /**
     * @param DocumentTemplate $documentTemplate
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setDocumentTemplate(DocumentTemplate $documentTemplate): void
    {
        $this->documentTemplate = $documentTemplate;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImagePreview(): ?string
    {
        return $this->imagePreview;
    }

    /**
     * @param string|null $imagePreview
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImagePreview(?string $imagePreview): void
    {
        $this->imagePreview = $imagePreview;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImageBackground(): ?string
    {
        return $this->imageBackground;
    }

    /**
     * @param string|null $imageBackground
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImageBackground(?string $imageBackground): void
    {
        $this->imageBackground = $imageBackground;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeInterface|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param File|null $imagePreviewFile
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImagePreviewFile(?File $imagePreviewFile): void
    {
        $this->imagePreviewFile = $imagePreviewFile;
        if ($imagePreviewFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|null $imageBackgroundFile
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImageBackgroundFile(?File $imageBackgroundFile): void
    {
        $this->imageBackgroundFile = $imageBackgroundFile;
        if ($imageBackgroundFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @return File|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImagePreviewFile(): ?File
    {
        return $this->imagePreviewFile;
    }

    /**
     * @return File|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImageBackgroundFile(): ?File
    {
        return $this->imageBackgroundFile;
    }
}
