<?php

namespace App\Tests\unit\App\Domain\Entity\School;

use App\Domain\Entity\School\School;
use Codeception\Test\Unit;

/**
 * Class SchoolTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\School
 * @covers  \App\Domain\Entity\School\School
 */
class SchoolTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $school = new School(
            1,
            'Name',
        );

        $this->assertEquals(1, $school->getId());
        $this->assertEquals('Name', $school->getName());
    }
}
