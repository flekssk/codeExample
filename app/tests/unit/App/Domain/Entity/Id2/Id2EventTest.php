<?php

namespace App\Tests\unit\App\Domain\Entity\Id2;

use App\Domain\Entity\Id2\Id2Event;
use Codeception\Test\Unit;

/**
 * Class Id2EventTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Id2
 * @covers \App\Domain\Entity\Id2\Id2Event
 */
class Id2EventTest extends Unit
{
    /**
     * Test create id2 event.
     */
    public function testCreateId2Event()
    {
        $updatedAt = new \DateTimeImmutable();

        $position = new Id2Event();
        $position->setId(1);
        $position->setName("name");
        $position->setAction("action");
        $position->setCategory1("category1");
        $position->setCategory2("category2");
        $position->setUpdatedAt($updatedAt);

        $this->assertEquals(1, $position->getId());
        $this->assertEquals("name", $position->getName());
        $this->assertEquals("action", $position->getAction());
        $this->assertEquals("category1", $position->getCategory1());
        $this->assertEquals("category2", $position->getCategory2());
        $this->assertEquals($updatedAt, $position->getUpdatedAt());
    }
}
