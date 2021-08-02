<?php

declare(strict_types=1);

namespace App\Domain\Entity\ValueObject;

class Limit
{
    /**
     * @var integer
     */
    private int $offset;

    /**
     * @var integer
     */
    private int $limit;

    /**
     * Limit constructor.
     * @param int $offset
     * @param int $limit
     */
    public function __construct(int $offset, int $limit)
    {
        if ($offset < 0) {
            throw new \DomainException('Offset must be positive');
        }
        if ($limit < 1) {
            throw new \DomainException('Limit must be greater than zero');
        }
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return self
     */
    public static function createFromPageNumberAndSize(int $page, int $perPage): self
    {
        $offset = ($page - 1) * $perPage;
        return new self($offset, $perPage);
    }
}

