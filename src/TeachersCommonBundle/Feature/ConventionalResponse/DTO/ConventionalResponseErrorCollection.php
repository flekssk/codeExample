<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\DTO;

final class ConventionalResponseErrorCollection
{
    /**
     * @var ConventionalResponseErrorDTO[]
     */
    private array $errors;

    public function __construct(ConventionalResponseErrorDTO ...$errors)
    {
        $this->errors = $errors;
    }

    public function findByCodeAndProperty(string $code, string $property): self
    {
        $result = [];

        foreach ($this->errors as $error) {
            if ($error->property() === $property && $error->error()->code() === $code) {
                $result[] = $error;
            }
        }

        return new self(...$result);
    }

    public function findByCode(string $code): self
    {
        $result = [];

        foreach ($this->errors as $error) {
            if ($error->error()->code() === $code) {
                $result[] = $error;
            }
        }

        return new self(...$result);
    }

    public function isNotEmpty(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @return ConventionalResponseErrorDTO[]
     */
    public function toArray(): array
    {
        return $this->errors;
    }
}
