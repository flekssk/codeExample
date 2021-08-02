<?php

namespace App\Domain\Entity\Specialist;

/**
 * Class SpecialistOccupationType.
 *
 * Сущность "Тип занятости"
 *
 * @package App\Domain\Entity\Specialist
 */
class SpecialistOccupationType
{
    /**
     * ID записи
     *
     * @var int
     */
    private int $id;

    /**
     * Название
     *
     * @var string
     */
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
