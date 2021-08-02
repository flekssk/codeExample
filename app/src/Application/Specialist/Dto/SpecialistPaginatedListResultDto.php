<?php

namespace App\Application\Specialist\Dto;

/**
 * Class SpecialistPaginatedListResultDto.
 *
 * @package App\Application\Specialist\Dto
 */
class SpecialistPaginatedListResultDto
{
    /**
     * @var SpecialistResultDto[]
     */
    public array $specialists;

    /**
     * @var int
     */
    public int $page;

    /**
     * @var int
     */
    public int $perPage;

    /**
     * @var int
     */
    public int $totalCount;
}
