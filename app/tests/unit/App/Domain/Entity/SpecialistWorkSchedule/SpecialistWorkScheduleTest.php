<?php

namespace App\Tests\unit\App\Domain\Entity\SpecialistWorkSchedule;

use Codeception\Test\Unit;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;

/**
 * Class SpecialistWorkScheduleTest.
 *
 * @covers \App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule
 */
class SpecialistWorkScheduleTest extends Unit
{

    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $schedule = new SpecialistWorkSchedule();
        $schedule->setId(1);
        $schedule->setName("name");

        $this->assertEquals(1, $schedule->getId());
        $this->assertEquals("name", $schedule->getName());
    }
}
