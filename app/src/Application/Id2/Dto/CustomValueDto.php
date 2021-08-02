<?php

declare(strict_types=1);

namespace App\Application\Id2\Dto;

use Swagger\Annotations as SWG;

/**
 * Class CustomValueDto.
 *
 * @package \App\Application\CustomValue\Dto
 *
 * @SWG\Definition()
 */
class CustomValueDto
{
    /**
     * Наименование.
     *
     * @var string
     */
    public string $name;

    /**
     * Ключ.
     *
     * @var string|null
     */
    public ?string $key;

    /**
     * Значение.
     *
     * @var string|null
     */
    public ?string $value;
}
