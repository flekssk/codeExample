<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistCount\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistCountDto.
 *
 * @package App\Application\Specialist\SpecialistCountDto
 *
 */
class SpecialistCountDto
{
    /**
     * Количество.
     *
     * @var int
     * @SWG\Property(example=1)
     */
    public int $count;
}
