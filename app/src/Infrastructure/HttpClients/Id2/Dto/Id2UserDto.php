<?php

namespace App\Infrastructure\HttpClients\Id2\Dto;

use App\Domain\Entity\ValueObject\Gender;

/**
 * Class Id2UserDto.
 *
 * @package App\Infrastructure\HttpClients\Id2\Dto
 */
class Id2UserDto
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $secondName;

    /**
     * @var string|null
     */
    public ?string $middleName;

    /**
     * @var Gender|null
     */
    public ?Gender $gender;

    /**
     * @var string
     */
    public string $region;

    /**
     * @var \DateTimeInterface|null
     */
    public ?\DateTimeInterface $birthDate;

    /**
     * @var string
     */
    public string $position;

    /**
     * @var string
     */
    public string $avatar;

    /**
     * @var string
     */
    public string $company;
}
