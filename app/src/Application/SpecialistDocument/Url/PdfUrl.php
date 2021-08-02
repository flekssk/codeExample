<?php

namespace App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\BaseUrl;

/**
 * Class PdfUrl.
 */
class PdfUrl extends BaseUrl
{

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return "/document/{$this->document->getId()}/document.pdf";
    }
}
