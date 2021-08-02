<?php

namespace App\Tests\unit\App\Domain\Entity\ReferenceInformation;

use App\Domain\Entity\ReferenceInformation\ReferenceInformation;
use Codeception\Test\Unit;

/**
 * Class ReferenceInformationTest.
 *
 * @covers \App\Domain\Entity\ReferenceInformation\ReferenceInformation
 */
class ReferenceInformationTest extends Unit
{
    /**
     * Тестируем создание сущности.
     */
    public function testCreateEntity()
    {
        $entity = new ReferenceInformation();
        $entity->setId(1);
        $entity->setTitle("title");
        $entity->setUrl("url");
        $entity->setActive(true);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals("title", $entity->getTitle());
        $this->assertEquals("url", $entity->getUrl());
        $this->assertEquals(true, $entity->isActive());
    }
}
