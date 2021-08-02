<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\Specialist\ValueObject;

use App\Domain\Entity\Specialist\Specialist;
use Codeception\Test\Unit;

/**
 * Class SpecialistTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist\ValueObject
 * @covers  \App\Domain\Entity\Specialist\Specialist
 */
class SpecialistTest extends Unit
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
        new Specialist($value);
    }

    /**
     * Test incorrect value should raise exception.
     *
     * @param $value
     *
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseTypeErrorException($value): void
    {
        $this->expectException(\TypeError::class);

        new Specialist("");
    }

    /**
     * @param $value
     *
     * @dataProvider correctValueDataProvider
     */
    public function testGetIdShouldReturnEqualId($value): void
    {
        $specialist = new Specialist($value);

        $this->assertEquals($specialist->getId(), $value);
    }

    /**
     * Correct value data provider.
     *
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            [1],
            [4574],
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

    public function testIsHasPositionShouldReturnTrueIfPositionIsSet()
    {
        $specialist = new Specialist(1);
        $specialist->setPosition('test');

        $result = $specialist->isHasPosition();

        $this->assertTrue($result);
    }

    public function testIsHasPositionShouldReturnFalseIfPositionIsNotSet()
    {
        $specialist = new Specialist(1);

        $result = $specialist->isHasPosition();

        $this->assertFalse($result);
    }

    public function testCreateEntity()
    {
        $document = new Specialist(1);
        $document->setDateCheckAccess(new \DateTimeImmutable('2020-01-01'));

        $this->assertEquals('2020-01-01', $document->getDateCheckAccess()->format('Y-m-d'));
    }
}
