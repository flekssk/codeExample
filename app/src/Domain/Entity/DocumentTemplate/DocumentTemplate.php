<?php

namespace App\Domain\Entity\DocumentTemplate;

use DateTimeInterface;

/**
 * Class DocumentTemplate.
 *
 * @package App\Domain\Entity\DocumentTemplate
 */
class DocumentTemplate
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $documentType;

    /**
     * @var string
     */
    private string $disciplinesName;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $year;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getId(): string
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
    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    /**
     * @param string|null $documentType
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDocumentType(?string $documentType): void
    {
        $this->documentType = $documentType;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getDisciplinesName(): string
    {
        return $this->disciplinesName;
    }

    /**
     * @param string $disciplinesName
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDisciplinesName(string $disciplinesName): void
    {
        $this->disciplinesName = $disciplinesName;
    }

    /**
     * @return DateTimeInterface
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getYear(): DateTimeInterface
    {
        return $this->year;
    }

    /**
     * @param DateTimeInterface $year
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setYear(DateTimeInterface $year): void
    {
        $this->year = $year;
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

    /**
     * SpecialistDocumentTemplate constructor.
     *
     * @param string $id
     * @param string $name
     * @param string|null $documentType
     * @param string $disciplinesName
     * @param DateTimeInterface $year
     */
    public function __construct(
        string $id,
        string $name,
        ?string $documentType,
        string $disciplinesName,
        DateTimeInterface $year
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->documentType = $documentType;
        $this->disciplinesName = $disciplinesName;
        $this->year = $year;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore getter
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}
