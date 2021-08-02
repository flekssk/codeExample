<?php

namespace App\Domain\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product.
 *
 * Сущность "Продукт".
 *
 * @ORM\Entity(repositoryClass="App\Infrastructure\Persistence\Doctrine\Repository\Product\ProductRepository")
 */
class Product
{
    /**
     * @var int
     */
    private int $id;

    /**
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
