<?php

namespace App\Tests\unit\App\Domain\Entity\Position;

use Codeception\Test\Unit;
use App\Domain\Entity\Position\Position;

/**
 * Class PositionTest.
 *
 * @covers \App\Domain\Entity\Position\Position
 */
class PositionTest extends Unit
{

    /**
     * Test create position.
     */
    public function testCreatePosition()
    {
        $position = new Position();
        $position->setId(1);
        $position->setName("name");
        $position->setGuid("guid");

        $this->assertEquals(1, $position->getId());
        $this->assertEquals("name", $position->getName());
        $this->assertEquals("guid", $position->getGuid());
    }
}
