<?php

namespace App\UI\Controller\Api\Specialist\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistSearchListResponseDto.
 *
 * @package App\UI\Controller\Api\Specialist\Dto
 */
class SpecialistSearchListResponseDto
{
    /**
     * @var SpecialistSearchResponseDto[]
     */
    public array $result;

    /**
     * @var int
     *
     * @SWG\Property(
     *     type="integer",
     *     example="1"
     * )
     */
    public int $page;

    /**
     * @var int
     *
     * @SWG\Property(
     *     type="integer",
     *     example="1"
     * )
     */
    public int $perPage;

    /**
     * @var int
     *
     * @SWG\Property(
     *     type="integer",
     *     example="1"
     * )
     */
    public int $totalCount;
}
