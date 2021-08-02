<?php

namespace App\Domain\Entity\SpecialistDocument;

use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;

/**
 * Class SpecialistDocument.
 *
 * @package App\Domain\Entity\SpecialistDocument
 */
class SpecialistDocument
{

    /**
     * ID документа
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
     * Номер документа.
     *
     * @var string
     */
    private string $number;

    /**
     * Название документа.
     *
     * @var string
     */
    private string $name;

    /**
     * Название дисциплины.
     *
     * @var string
     */
    private string $disciplinesName;

    /**
     * Тип документа.
     *
     * @var string
     */
    private string $typeDocument;

    /**
     * GUID документа в CRM
     *
     * @var string
     */
    private string $crmId;

    /**
     * ID шаблона
     *
     * @var string
     */
    private string $templateId;

    /**
     * Дата выдачи документа
     *
     * @var \DateTime
     */
    private \DateTime $date;

    /**
     * Дата окончания действия документа
     *
     * @var \DateTime
     */
    private \DateTime $endDate;

    /**
     * Дата начала обучения
     *
     * @var \DateTime
     */
    private \DateTime $eduDateStart;

    /**
     * Дата окончания обучения
     *
     * @var \DateTime
     */
    private \DateTime $eduDateEnd;

    /**
     * Затрачено часов
     *
     * @var int
     */
    private int $hours;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSpecialistId(): int
    {
        return $this->specialistId;
    }

    /**
     * @return DocumentNumber
     */
    public function getNumber(): DocumentNumber
    {
        return new DocumentNumber($this->number);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisciplinesName(): string
    {
        return $this->disciplinesName;
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
     * @param int $specialistId
     * @return void
     */
    public function setSpecialistId(int $specialistId): void
    {
        $this->specialistId = $specialistId;
    }

    /**
     * @param DocumentNumber $number
     * @return void
     */
    public function setNumber(DocumentNumber $number): void
    {
        $this->number = $number->getValue();
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $disciplinesName
     * @return void
     */
    public function setDisciplinesName(string $disciplinesName): void
    {
        $this->disciplinesName = $disciplinesName;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    /**
     * @param string $templateId
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setTemplateId(string $templateId): void
    {
        $this->templateId = $templateId;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getEduDateStart(): \DateTime
    {
        return $this->eduDateStart;
    }

    /**
     * @param \DateTime $eduDateStart
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setEduDateStart(\DateTime $eduDateStart): void
    {
        $this->eduDateStart = $eduDateStart;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getEduDateEnd(): \DateTime
    {
        return $this->eduDateEnd;
    }

    /**
     * @param \DateTime $eduDateEnd
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setEduDateEnd(\DateTime $eduDateEnd): void
    {
        $this->eduDateEnd = $eduDateEnd;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getHours(): int
    {
        return $this->hours;
    }

    /**
     * @param int $hours
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setHours(int $hours): void
    {
        $this->hours = $hours;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getTypeDocument(): string
    {
        return $this->typeDocument;
    }

    /**
     * @param string $typeDocument
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setTypeDocument(string $typeDocument): void
    {
        $this->typeDocument = $typeDocument;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Getter
     */
    public function getCrmId(): string
    {
        return $this->crmId;
    }

    /**
     * @param string $crmId
     *
     * @codeCoverageIgnore
     * @ignore Setter
     */
    public function setCrmId(string $crmId): void
    {
        $this->crmId = $crmId;
    }
}
