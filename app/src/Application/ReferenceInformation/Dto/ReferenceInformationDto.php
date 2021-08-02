<?php

declare(strict_types=1);

namespace App\Application\ReferenceInformation\Dto;

use Swagger\Annotations as SWG;

/**
 * Class ReferenceInformationDto.
 *
 * @package \App\Application\ReferenceInformation\Dto
 *
 * @SWG\Definition()
 */
class ReferenceInformationDto
{
    /**
     * Наименование.
     *
     * @var string
     */
    public string $title;

    /**
     * Ссылка.
     *
     * @var string
     */
    public string $url;
}
