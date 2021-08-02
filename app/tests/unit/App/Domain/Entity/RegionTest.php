<?php

namespace App\Tests\unit\App\Domain\Entity\Position;

use Codeception\Test\Unit;
use App\Domain\Entity\Region\Region;

/**
 * Class RegionTest.
 *
 * @covers \App\Domain\Entity\Region\Region
 */
class RegionTest extends Unit
{

    /**
     * Тестируем создание сущности.
     */
    public function testCreateRegion()
    {
        $region = new Region();
        $region->setId(1);
        $region->setName("name");

        $this->assertEquals(1, $region->getId());
        $this->assertEquals("name", $region->getName());
    }
}
