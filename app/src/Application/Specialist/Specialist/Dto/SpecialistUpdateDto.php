<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Dto;

use Swagger\Annotations as SWG;

/**
 * Class SpecialistUpdateDto.
 *
 * @package App\Application\Specialist\Specialist\Dto
 *
 * @SWG\Definition(
 *     required={"id"}
 * )
 */
class SpecialistUpdateDto
{
    /**
     * Id пользователя в id2.
     *
     * @var int
     */
    public int $id;
}
