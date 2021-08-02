<?php

namespace App\Tests\unit\App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\PreviewUrl;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use Codeception\Test\Unit;

/**
 * Class PreviewUrlTest.
 *
 * @package App\Tests\unit\App\Application\SpecialistDocument\Url
 * @covers  \App\Application\SpecialistDocument\Url\PreviewUrl
 */
class PreviewUrlTest extends Unit
{

    public function testUrlShouldBeCorrected()
    {
        $document = new SpecialistDocument();
        $document->setId(100100);
        $url = new PreviewUrl($document);
        $this->assertEquals("/document/100100/preview.png", $url->getValue());
    }
}
