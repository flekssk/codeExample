<?php

namespace App\Application\Position\Dto;

use Swagger\Annotations as SWG;

/**
 * Class PositionResultDto.
 *
 * @SWG\Definition()
 */
class PositionResultDto
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;
}
