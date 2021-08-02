<?php

declare(strict_types=1);

namespace App\Application\RegulatoryDocuments\Dto;

use Swagger\Annotations as SWG;

/**
 * Class RegulatoryDocumentsDto.
 *
 * @package \App\Application\RegulatoryDocuments\Dto
 *
 * @SWG\Definition()
 */
class RegulatoryDocumentsDto
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
     * @var string|null
     */
    public ?string $url;
}
