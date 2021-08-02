<?php

namespace App\Tests\unit\App\Application\SpecialistDocument\Url;

use App\Application\SpecialistDocument\Url\ImageUrl;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use Codeception\Test\Unit;

/**
 * Class ImageUrlTest.
 *
 * @package App\Tests\unit\App\Application\SpecialistDocument\Url
 * @covers  \App\Application\SpecialistDocument\Url\ImageUrl
 */
class ImageUrlTest extends Unit
{

    public function testUrlShouldBeCorrected()
    {
        $document = new SpecialistDocument();
        $document->setId(100100);
        $url = new ImageUrl($document);
        $this->assertEquals("/document/100100/image.png", $url->getValue());
    }
}
