<?php

namespace App\Domain\Entity\ValueObject;

use Codeception\Test\Unit;

/**
 * Class GenderTest.
 *
 * @package App\Domain\Entity\ValueObject
 * @covers \App\Domain\Entity\ValueObject\Gender
 */
class GenderTest extends Unit
{
    /**
     * @param $value
     *
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($value): void
    {
        new Gender($value);
    }

    /**
     * Test incorrect value should raise exception.
     *
     * @param $value
     *
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($value): void
    {
        $this->expectException(\DomainException::class);

        new Gender($value);
    }

    /**
     * Test gender to string should return value.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testGenderToStringShouldReturnValue($value): void
    {
        $gender = new Gender($value);

        $this->assertEquals((string) $value, (string) $gender);
    }

    /**
     * Test gender getValue() should return value.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testGenderGetValueShouldReturnValue($value): void
    {
        $gender = new Gender($value);

        $this->assertEquals((int) $value, $gender->getValue());
    }

    /**
     * Test gender getName() should return Name.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testGenderGetValueShouldReturnName($value): void
    {
        $gender = new Gender($value);

        $this->assertTrue(strlen($gender->getName()) > 0);
    }

    /**
     * Test isEqual.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testIsEqual($value)
    {
        $firstGender = new Gender($value);
        $secondGender = new Gender($value);

        $this->assertTrue($firstGender->isEqual($secondGender));
    }

    /**
     * Test getValue.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testGetValue($value)
    {
        $gender = new Gender($value);

        $this->assertEquals($value, $gender->getValue());
    }

    /**
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            [0],
            [1],
            [2],
        ];
    }

    /**
     * @return array
     */
    public function incorrectValueDataProvider(): array
    {
        return [
            [-1],
            [3],
        ];
    }
}
