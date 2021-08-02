<?php

namespace App\UI\Controller\Api\Specialist\Dto;

use App\Application\SpecialistDocument\Dto\SpecialistDocumentShortDto;

/**
 * Class SpecialistSearchResponseDto.
 *
 * @package App\UI\Controller\Api\Specialist\Dto
 */
class SpecialistSearchResponseDto
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
     * @var string|null
     */
    public ?string $position;

    /**
     * @var string|null
     */
    public ?string $id2Position;

    /**
     * @var string
     */
    public ?string $region;

    /**
     * @var int
     */
    public int $status;

    /**
     * @var string|null
     */
    public ?string $company;

    /**
     * @var SpecialistDocumentShortDto|null
     */
    public ?SpecialistDocumentShortDto $document;
}
