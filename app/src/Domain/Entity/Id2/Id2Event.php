<?php

namespace App\Domain\Entity\Id2;

/**
 * Class Id2Event.
 *
 * @package App\Domain\Entity\id2
 */
class Id2Event
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
     * @var string
     */
    private string $action;

    /**
     * @var string|null
     */
    private ?string $category1;

    /**
     * @var string|null
     */
    private ?string $category2;

    /**
     * @var \DateTimeInterface|null
     */
    private ?\DateTimeInterface $updatedAt;

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

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string|null
     */
    public function getCategory1(): ?string
    {
        return $this->category1;
    }

    /**
     * @param string|null $category1
     */
    public function setCategory1(?string $category1): void
    {
        $this->category1 = $category1;
    }

    /**
     * @return string|null
     */
    public function getCategory2(): ?string
    {
        return $this->category2;
    }

    /**
     * @param string|null $category2
     */
    public function setCategory2(?string $category2): void
    {
        $this->category2 = $category2;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
