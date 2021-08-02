<?php

namespace App\Domain\Entity\School;

/**
 * Class School.
 *
 * @package App\Domain\Entity\School
 */
class School
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
     * School constructor.
     *
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

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
}
