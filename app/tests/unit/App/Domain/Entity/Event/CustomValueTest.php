<?php

namespace App\Tests\unit\App\Domain\Entity\Event;

use App\Domain\Entity\Event\CustomValue;
use App\Domain\Entity\Id2\Id2Event;
use Codeception\Test\Unit;

/**
 * Class CustomValueTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\Event
 * @covers \App\Domain\Entity\Event\CustomValue
 */
class CustomValueTest extends Unit
{
    /**
     * Test create custom value.
     */
    public function testCreateCustomValue()
    {
        $updatedAt = new \DateTimeImmutable();

        $position = new CustomValue();
        $position->setId(1);
        $position->setName("name");
        $position->setKey("key");
        $position->setValue("value");
        $position->setUpdatedAt($updatedAt);


        $this->assertEquals(1, $position->getId());
        $this->assertEquals("name", $position->getName());
        $this->assertEquals("key", $position->getKey());
        $this->assertEquals("value", $position->getValue());
        $this->assertEquals($updatedAt, $position->getUpdatedAt());
    }
}
