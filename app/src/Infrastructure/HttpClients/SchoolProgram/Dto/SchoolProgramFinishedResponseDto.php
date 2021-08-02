<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Dto;

/**
 * Class SchoolProgramFinishedResponseDto.
 *
 * @package App\Infrastructure\HttpClients\Skills\Dto
 */
class SchoolProgramFinishedResponseDto
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
    public ?string $programPost = null;

    /**
     * @var string|null
     */
    public ?string $programDateStart = null;

    /**
     * @var string|null
     */
    public ?string $programDateEnd = null;

    /**
     * @var float
     */
    public float $programProgress;
}
