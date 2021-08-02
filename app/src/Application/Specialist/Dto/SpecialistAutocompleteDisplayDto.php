<?php

namespace App\Application\Specialist\Dto;

/**
 * Class SpecialistAutocompleteDisplayDto.
 */
class SpecialistAutocompleteDisplayDto
{

    /**
     * @var int
     */
    public int $id;

    /**
     * @var string|null
     */
    public ?string $firstName;

    /**
     * @var string|null
     */
    public ?string $secondName;

    /**
     * @var string|null
     */
    public ?string $middleName;

    /**
     * @var int
     */
    public int $status;
}
