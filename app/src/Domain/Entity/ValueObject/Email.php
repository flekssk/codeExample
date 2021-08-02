<?php

declare(strict_types=1);

namespace App\Domain\Entity\ValueObject;

class Email
{
    /** @var string */
    private string $email;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException(sprintf('Wrong email format "%s"', $value));
        }

        $this->email = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
