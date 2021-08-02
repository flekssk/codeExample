<?php

namespace App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\BaseUrl;

/**
 * Class PreviewUrl.
 */
class PreviewUrl extends BaseUrl
{

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return "/document/{$this->document->getId()}/preview.png";
    }
}
