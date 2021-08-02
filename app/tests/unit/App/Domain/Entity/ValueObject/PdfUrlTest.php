<?php

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\PdfUrl;
use Codeception\Test\Unit;
use DomainException;

/**
 * Class PdfUrlTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\ValueObject
 *
 * @covers \App\Domain\Entity\ValueObject\PdfUrl
 */
class PdfUrlTest extends Unit
{
    /**
     * @param string $url
     *
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException(string $url): void
    {
        new PdfUrl($url);
    }

    /**
     * @param string $url
     *
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException(string $url): void
    {
        $this->expectException(DomainException::class);

        new PdfUrl($url);
    }

    /**
     * @param $url
     *
     * @dataProvider correctValueDataProvider
     */
    public function testGetUrlShouldReturnCorrectValue(string $url): void
    {
        $limitDto = new PdfUrl($url);
        $this->assertEquals($url, $limitDto->getUrl());
    }

    /**
     * Test url with different value should return is equal false.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testIdWithDifferentValueShouldReturnIsEqualFalse($value): void
    {
        $url = new PdfUrl($value);
        $anotherUrl = new PdfUrl($value . 'https://test.ru/another_url.pdf');

        $result = $url->isEqual($anotherUrl);

        $this->assertFalse($result);
    }

    /**
     * Test url with same value should return is equal true.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testUrlWithSameValueShouldReturnIsEqualTrue($value): void
    {
        $url = new PdfUrl($value);
        $anotherUrl = new PdfUrl($value);

        $result = $url->isEqual($anotherUrl);

        $this->assertTrue($result);
    }


    /**
     * @return array|\string[][]
     */
    public function correctValueDataProvider(): array
    {
        return [
            ['https://test.ru/pdf.pdf'],
            ['http://test.ru/pdf.pdf'],
        ];
    }

    /**
     * @return array|\string[][]
     */
    public function incorrectValueDataProvider(): array
    {
        return [
            ['https://test.ru'],
            ['httpsdd://test.ru'],
            ['string'],
            ['test.ru/pdf.pdf'],
        ];
    }
}
