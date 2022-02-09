<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\Trm\DTO;

/** @psalm-immutable */
class OrderByClauseDTO
{
    public string $property;

    public string $direction;

    public function __construct(string $property, string $direction = 'ASC')
    {
        $this->property = $property;
        $this->direction = $direction;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
