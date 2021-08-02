<?php

declare(strict_types=1);

namespace App\Application\Id2\Dto;

use Swagger\Annotations as SWG;

/**
 * Class Id2EventDto.
 *
 * @package \App\Application\Id2Event\Dto
 *
 * @SWG\Definition()
 */
class Id2EventDto
{
    /**
     * Наименование.
     *
     * @var string
     */
    public string $name;

    /**
     * Action.
     *
     * @var string
     */
    public string $action;

    /**
     * Category1.
     *
     * @var string|null
     */
    public ?string $category1;

    /**
     * Category2.
     *
     * @var string|null
     */
    public ?string $category2;
}
