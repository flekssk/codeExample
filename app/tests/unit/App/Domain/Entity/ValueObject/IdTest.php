<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\Id;
use Codeception\Test\Unit;

class IdTest extends Unit
{
    private const CORRECT_ID_VALUE = '7d1099c6-444b-437a-bc57-cdf81ce36982';

    /**
     * @param $value
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($value): void
    {
        new Id($value);
    }

    /**
     * @param $value
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($value): void
    {
        $this->expectException(\DomainException::class);

        new Id($value);
    }

    public function testIdToStringShouldReturnValue(): void
    {
        $id = new Id(self::CORRECT_ID_VALUE);

        $this->assertEquals(self::CORRECT_ID_VALUE, (string)$id);
    }

    public function testIdToJsonShouldReturnValue(): void
    {
        $id = new Id(self::CORRECT_ID_VALUE);
        $result = json_encode($id);
        $expected = '"'.self::CORRECT_ID_VALUE.'"';

        $this->assertEquals($expected, $result);
    }

    public function testIdWithSameValueShouldReturnIsEqualTrue(): void
    {
        $id = new Id(self::CORRECT_ID_VALUE);
        $anotherId = new Id(self::CORRECT_ID_VALUE);

        $result = $id->isEqual($anotherId);

        $this->assertTrue($result);
    }

    public function testIdWithDifferentValueShouldReturnIsEqualFalse(): void
    {
        $id = new Id(self::CORRECT_ID_VALUE);
        $anotherId = new Id('another_id');

        $result = $id->isEqual($anotherId);

        $this->assertFalse($result);
    }

    public function correctValueDataProvider(): array
    {
        return [
            [self::CORRECT_ID_VALUE],
        ];
    }

    public function incorrectValueDataProvider(): array
    {
        return [
            [''],
        ];
    }
}
