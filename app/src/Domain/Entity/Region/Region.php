<?php

namespace App\Domain\Entity\Region;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Region.
 *
 * Сущность "Регион".
 *
 * @ORM\Entity(repositoryClass="App\Domain\Entity\Region\Region\RegionRepository")
 */
class Region
{
    /**
     * ID
     *
     * @Assert\NotBlank
     * @var int
     */
    private int $id;

    /**
     * Название.
     *
     * @Assert\NotBlank
     * @var string
     */
    private string $name;

    /**
     * @return int
     *
     * @codeCoverageIgnore
     * @ignore getter
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore getter
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
     * @ignore setter
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
     * @ignore setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     * @ignore getter
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
