<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity;

use App\Domain\Entity\SiteOption;
use Codeception\Test\Unit;

/**
 * Class SiteOptionTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist\ValueObject
 * @covers \App\Domain\Entity\SiteOption
 */
class SiteOptionTest extends Unit
{
    /**
     * Test correct value should not raise exception.
     *
     * @param $value
     *
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($value): void
    {
        new SiteOption($value);
    }

    /**
     * Test incorrect value type should raise type error exception.
     *
     * @param $value
     *
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueTypeShouldRaiseTypeErrorException($value): void
    {
        $this->expectException(\TypeError::class);

        new SiteOption($value);
    }

    /**
     * Test get name should return equal value.
     *
     * @param $value
     *
     * @dataProvider correctValueDataProvider
     */
    public function testGetNameShouldReturnEqualValue($value): void
    {
        $siteOption = new SiteOption($value);

        $this->assertEquals($siteOption->getName(), $value);
    }

    /**
     * Correct value data provider.
     *
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            ['option_name'],
        ];
    }

    /**
     * Incorrect value data provider.
     *
     * @return array
     */
    public function incorrectValueDataProvider(): array
    {
        return [
            [1],
        ];
    }
}
