<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\Url;
use Codeception\Test\Unit;

/**
 * Class FIleURLTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\ValueObject
 * @covers \App\Domain\Entity\ValueObject\Url
 */
class UrlTest extends Unit
{
    /**
     * Test correct value should not raise exception.
     *
     * @param $url
     *
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($url): void
    {
        new Url($url);
    }

    /**
     * Test incorrect value should raise exception.
     *
     * @param $url
     *
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($url): void
    {
        $this->expectException(\DomainException::class);

        new Url($url);
    }

    /**
     * Test url to string should return value.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testUrlToStringShouldReturnValue($value): void
    {
        $url = new Url($value);

        $this->assertEquals($value, (string) $url);
    }

    /**
     * Test getUrl() should return value.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testGetUrlShouldReturnValue($value): void
    {
        $url = new Url($value);

        $this->assertEquals($value, $url->getUrl());
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
        $url = new Url($value);
        $anotherUrl = new Url($value);

        $result = $url->isEqual($anotherUrl);

        $this->assertTrue($result);
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
        $url = new Url($value);
        $anotherUrl = new Url($value . '/another_url');

        $result = $url->isEqual($anotherUrl);

        $this->assertFalse($result);
    }

    /**
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            ['https://test.ru/test.php'],
            ['https://test.com'],
            ['http://test.com/try.json'],
            ['http://test.ru/file'],
            ['ftp://test.ru'],
        ];
    }

    /**
     * @return array
     */
    public function incorrectValueDataProvider(): array
    {
        return [
            ['abc.example.com'],
            ['test.ru'],
            ['just"not"right@example.com'],
            ['this is"not\allowed@example.com'],
            ['this\ still\"not\allowed@example.com'],
        ];
    }
}
