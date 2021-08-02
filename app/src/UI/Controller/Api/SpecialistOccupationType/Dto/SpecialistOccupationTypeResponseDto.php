<?php

namespace App\UI\Controller\Api\SpecialistOccupationType\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistOccupationTypeResponseDto.
 *
 * @SWG\Definition()
 */
class SpecialistOccupationTypeResponseDto
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
