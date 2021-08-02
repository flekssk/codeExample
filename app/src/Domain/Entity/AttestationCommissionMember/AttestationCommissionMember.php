<?php

namespace App\Domain\Entity\AttestationCommissionMember;

use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class AttestationCommissionMember.
 *
 * @Vich\Uploadable()
 *
 * @package App\Domain\Entity\AttestationCommissionMember
 */
class AttestationCommissionMember
{
    /**
     * @var int|null
     */
    private ?int $id = 0;

    /**
     * @var string
     */
    private string $firstName = '';

    /**
     * @var string
     */
    private string $secondName = '';

    /**
     * @var string|null
     */
    private ?string $middleName = '';

    /**
     * @var string|null
     */
    private ?string $imageUrl = '';

    /**
     * Файл изображения.
     *
     * @Vich\UploadableField(mapping="attestation_commission_member_avatar", fileNameProperty="imageUrl")
     *
     * @var File|null
     */
    private ?File $imageFile = null;

    /**
     * @var string
     */
    private string $description = '';

    /**
     * @var bool
     */
    private bool $isLeader = false;

    /**
     * Активность.
     *
     * @var bool
     */
    private bool $active = true;

    /**
     * Дата последнего изменения.
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt = null;

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getSecondName(): string
    {
        return $this->secondName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function isLeader(): bool
    {
        return $this->isLeader;
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
     * @return File|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
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
     * @param string $firstName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $secondName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setSecondName(string $secondName): void
    {
        $this->secondName = $secondName;
    }

    /**
     * @param string|null $middleName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @param string|null $imageUrl
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param string $description
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param bool $isLeader
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setIsLeader(bool $isLeader): void
    {
        $this->isLeader = $isLeader;
    }

    /**
     * @param int $id
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @param File|null $imageFile
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }
}
