<?php

namespace App\Domain\Entity\SpecialistWorkSchedule;

/**
 * Class SpecialistWorkSchedule.
 *
 * Сущность "График работы"
 */
class SpecialistWorkSchedule
{

    /**
     * Идентификатор.
     *
     * @var int
     */
    private int $id;

    /**
     * Название.
     *
     * @var string
     */
    private string $name;

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
     * @param int $id
     * @return void
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     * @return void
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
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
