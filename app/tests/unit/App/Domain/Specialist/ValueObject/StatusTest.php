<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\Specialist\ValueObject;

use App\Domain\Entity\Specialist\ValueObject\Status;
use Codeception\Test\Unit;
use DomainException;

/**
 * Class StatusTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Specialist\ValueObject
 * @covers \App\Domain\Entity\Specialist\ValueObject\Status
 */
class StatusTest extends Unit
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
        new Status($value);
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
        $this->expectException(DomainException::class);

        new Status($value);
    }

    /**
     * Test status to string should return value.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     */
    public function testIdToStringShouldReturnValue($value): void
    {
        $returnValue = new Status($value);

        $this->assertEquals($returnValue, Status::STATUS_LIST[$value]);
    }

    /**
     * Test statuses with same value should return is equal true.
     *
     * @dataProvider correctValueDataProvider
     *
     * @param $value
     * @covers \App\Domain\Entity\Specialist\ValueObject\Status::isEqual
     */
    public function testIsEqual($value): void
    {
        $status = new Status($value);
        $anotherStatus = new Status($value);

        $result = $status->isEqual($anotherStatus);

        $this->assertTrue($result);
    }

    /**
     * Test id with different value should return is equal false.
     *
     * @dataProvider differentCorrectValueDataProvider
     *
     * @param $firstValue
     * @param $secondValue
     */
    public function testIdWithDifferentValueShouldReturnIsEqualFalse($firstValue, $secondValue): void
    {
        $id = new Status($firstValue);
        $anotherId = new Status($secondValue);

        $result = $id->isEqual($anotherId);

        $this->assertFalse($result);
    }

    /**
     * Correct value data provider.
     *
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            [0],
            [1],
            [2],
            [3],
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
            [4],
            [5],
        ];
    }

    /**
     * @param int $id
     *
     * @dataProvider correctValueDataProvider
     *
     * @covers \App\Domain\Entity\Specialist\ValueObject\Status::getStatusName
     */
    public function testGetStatusName(int $id)
    {
        $status = new Status($id);

        $this->assertEquals(Status::STATUS_LIST[$id], $status->getStatusName());
    }

    /**
     * Different correct value data provider.
     *
     * @return array
     */
    public function differentCorrectValueDataProvider(): array
    {
        return [
            [1, 2],
            [0, 3],
        ];
    }
}
