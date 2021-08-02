<?php

namespace App\Tests\unit\App\Domain\Entity\Specialist;

use Codeception\Test\Unit;
use App\Domain\Entity\Specialist\SpecialistOccupationType;

/**
 * Class SpecialistOccupationTypeTest.
 *
 * @covers \App\Domain\Entity\Specialist\SpecialistOccupationType
 */
class SpecialistOccupationTypeTest extends Unit
{

    /**
     * Тестируем создание сущности.
     */
    public function testCreateEntity()
    {
        $entity = new SpecialistOccupationType();
        $entity->setId(1);
        $entity->setName("name");

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals("name", $entity->getName());
    }
}
