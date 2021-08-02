<?php

namespace App\Domain\Entity\Position;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Position.
 *
 * Сущность "Должность".
 *
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 */
class Position
{

    /**
     * @var int
     */
    private int $id;

    /**
     * @Assert\NotBlank
     */
    private string $name;

    /**
     * @Assert\NotBlank
     */
    private string $guid;

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
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore Simple getter
     */
    public function getGuid(): string
    {
        return $this->guid;
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
     * @param string $guid
     *
     * @codeCoverageIgnore
     * @ignore Simple setter
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
