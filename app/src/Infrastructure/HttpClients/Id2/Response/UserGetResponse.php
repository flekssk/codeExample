<?php

namespace App\Infrastructure\HttpClients\Id2\Response;

use DateTimeInterface;

/**
 * Class UserGetResponse.
 *
 * @package App\Infrastructure\HttpClients\Id2\Response
 */
class UserGetResponse
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string|null
     */
    public ?string $phone;

    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string|null
     */
    public ?string $middleName;

    /**
     * @var int|null
     */
    public ?int $gender;

    /**
     * @var DateTimeInterface|null
     */
    public ?DateTimeInterface $birthDate;

    /**
     * @var array
     */
    public array $properties;
}
