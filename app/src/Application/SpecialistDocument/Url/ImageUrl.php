<?php

namespace App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\BaseUrl;

/**
 * Class ImageUrl.
 */
class ImageUrl extends BaseUrl
{

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return "/document/{$this->document->getId()}/image.png";
    }
}
