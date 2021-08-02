<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto;

/**
 * Class SpecialistFindDto.
 *
 * Dto для репозитория поиска.
 *
 * @package App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto
 */
class SpecialistFindDto
{
    /**
     * @var string
     */
    public string $searchString;

    /**
     * @var string
     */
    public string $company;

    /**
     * @var string
     */
    public string $id2Position;

    /**
     * @var string
     */
    public string $document;

    /**
     * @var string
     */
    public string $region;

    /**
     * @var int|null
     */
    public ?int $status;
}
