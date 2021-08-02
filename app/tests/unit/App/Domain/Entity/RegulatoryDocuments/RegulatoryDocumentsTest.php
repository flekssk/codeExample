<?php

namespace App\Tests\unit\App\Domain\Entity\RegulatoryDocuments;

use App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments;
use Codeception\Test\Unit;

/**
 * Class RegulatoryDocumentsTest.
 *
 * @covers \App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments
 */
class RegulatoryDocumentsTest extends Unit
{

    /**
     * Тестируем создание сущности.
     */
    public function testCreateEntity()
    {
        $entity = new RegulatoryDocuments();
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
