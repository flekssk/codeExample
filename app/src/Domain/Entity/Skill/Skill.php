<?php

namespace App\Domain\Entity\Skill;

/**
 * Class Skill.
 *
 * @package App\Domain\Entity\Skill
 */
class Skill
{
    /**
     * @var int
     */
    private int $internalId;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var \DateTimeImmutable|null
     */
    public ?\DateTimeImmutable $updatedAt;

    /**
     * @var string|null
     */
    private ?string $macroSkillId;

    /**
     * @var string|null
     */
    private ?string $macroSkillName;

    /**
     * @var string|null
     */
    private ?string $macroTypeId;

    /**
     * @var string|null
     */
    private ?string $macroTypeName;

    /**
     * @var string|null
     */
    private ?string $reestrId;

    /**
     * @var string|null
     */
    private ?string $reestrName;

    /**
     * @var int
     */
    private int $macroWeight = 0;

    /**
     * @var int
     */
    private int $weight = 0;

    /**
     * Флаг активности.
     *
     * @var bool
     */
    private bool $active = true;

    /**
     * Skill constructor.
     *
     * @param string $id
     * @param string $name
     * @param string|null $macroSkillId
     * @param string|null $macroSkillName
     * @param string|null $macroTypeId
     * @param string|null $macroTypeName
     * @param string|null $reestrId
     * @param string|null $reestrName
     */
    public function __construct(
        string $id,
        string $name,
        ?string $macroSkillId,
        ?string $macroSkillName,
        ?string $macroTypeId,
        ?string $macroTypeName,
        ?string $reestrId,
        ?string $reestrName
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->macroSkillId = $macroSkillId;
        $this->macroSkillName = $macroSkillName;
        $this->macroTypeId = $macroTypeId;
        $this->macroTypeName = $macroTypeName;
        $this->reestrId = $reestrId;
        $this->reestrName = $reestrName;
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
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getInternalId(): int
    {
        return $this->internalId;
    }

    /**
     * @return \DateTimeImmutable|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable|null $updatedAt
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTimeImmutable|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable|null $createdAt
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->updatedAt = $createdAt;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMacroSkillId(): ?string
    {
        return $this->macroSkillId;
    }

    /**
     * @param string|null $macroSkillId
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMacroSkillId(?string $macroSkillId): void
    {
        $this->macroSkillId = $macroSkillId;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMacroSkillName(): ?string
    {
        return $this->macroSkillName;
    }

    /**
     * @param string|null $macroSkillName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMacroSkillName(?string $macroSkillName): void
    {
        $this->macroSkillName = $macroSkillName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMacroTypeId(): ?string
    {
        return $this->macroTypeId;
    }

    /**
     * @param string|null $macroTypeId
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMacroTypeId(?string $macroTypeId): void
    {
        $this->macroTypeId = $macroTypeId;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMacroTypeName(): ?string
    {
        return $this->macroTypeName;
    }

    /**
     * @param string|null $macroTypeName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMacroTypeName(?string $macroTypeName): void
    {
        $this->macroTypeName = $macroTypeName;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getReestrId(): ?string
    {
        return $this->reestrId;
    }

    /**
     * @param string|null $reestrId
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setReestrId(?string $reestrId): void
    {
        $this->reestrId = $reestrId;
    }

    /**
     * @return string|null
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getReestrName(): ?string
    {
        return $this->reestrName;
    }

    /**
     * @param string|null $reestrName
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setReestrName(?string $reestrName): void
    {
        $this->reestrName = $reestrName;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getMacroWeight(): int
    {
        return $this->macroWeight;
    }

    /**
     * @param int $macroWeight
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setMacroWeight(int $macroWeight): void
    {
        $this->macroWeight = $macroWeight;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
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
}
