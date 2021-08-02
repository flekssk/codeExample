<?php

namespace App\Tests\unit\App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\PdfUrl;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use Codeception\Test\Unit;

/**
 * Class PreviewUrlTest.
 *
 * @package App\Tests\unit\App\Application\SpecialistDocument\Url
 * @covers  \App\Application\SpecialistDocument\Url\PdfUrl
 */
class PdfUrlTest extends Unit
{

    public function testUrlShouldBeCorrected()
    {
        $document = new SpecialistDocument();
        $document->setId(100100);
        $url = new PdfUrl($document);
        $this->assertEquals("/document/100100/document.pdf", $url->getValue());
    }
}
