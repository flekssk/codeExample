<?php

namespace App\Tests\unit\App\Domain\Entity\Region;

use App\Domain\Entity\Region\Region;
use Codeception\Test\Unit;

/**
 * Class RegionTest.
 *
 * @covers \App\Domain\Entity\Region\Region
 */
class RegionTest extends Unit
{

    /**
     * Test create region.
     */
    public function testCorrectValueShouldNotRaiseException(): void
    {
        new Region();
    }

    /**
     * @param int $id
     *
     * @dataProvider correctValueDataProvider
     */
    public function testGetIdShouldReturnEqualId($id): void
    {
        $specialist = new Region();

        $specialist->setId($id);

        $this->assertEquals($specialist->getId(), $id);
    }


    /**
     * Correct value data provider.
     *
     * @return array
     */
    public function correctValueDataProvider(): array
    {
        return [
            [
                1,
            ],
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
            [
                'test',
            ],
        ];
    }
}
