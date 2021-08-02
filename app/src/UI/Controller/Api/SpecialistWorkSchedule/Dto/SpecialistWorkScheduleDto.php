<?php

namespace App\UI\Controller\Api\SpecialistWorkSchedule\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistWorkScheduleDto.
 *
 * @SWG\Definition()
 */
class SpecialistWorkScheduleDto
{

    /**
     * Идентификатор.
     *
     * @var int
     */
    public int $id;

    /**
     * Название.
     *
     * @var string
     */
    public string $name;
}
