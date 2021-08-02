<?php

namespace App\UI\Controller\Api\SiteOption\Dto;

/**
 * Class SiteOptionResponseDto.
 *
 * @package App\UI\Controller\Api\SiteOption\Dto
 */
class SiteOptionResponseDto
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
