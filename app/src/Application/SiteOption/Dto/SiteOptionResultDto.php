<?php

declare(strict_types=1);

namespace App\Application\SiteOption\Dto;

/**
 * Class SiteOptionResultDto.
 *
 * @package App\Application\SiteOption\Dto
 */
class SiteOptionResultDto
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    public ?string $value;
}
