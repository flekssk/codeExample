<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Dto;

/**
 * Class SchoolProgramResponseDto.
 *
 * @package App\Infrastructure\HttpClients\Skills\Dto
 */
class SchoolProgramResponseDto
{
    /**
     * @var int
     */
    public int $programId;

    /**
     * @var string
     */
    public string $programTitle;

    /**
     * @var string|null
     */
    public ?string $programPost;

    /**
     * @var int
     */
    public int $defaultDurationInMonths;

    /**
     * @var int
     */
    public int $defaultDurationInHours;

    /**
     * @var string|null
     */
    public ?string $documentType;

    /**
     * @var string
     */
    public string $programLink;

    /**
     * @var float
     */
    public float $programProgress = 0;
}
