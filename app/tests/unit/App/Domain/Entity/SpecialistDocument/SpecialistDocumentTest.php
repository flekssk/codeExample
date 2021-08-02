<?php

namespace App\Tests\unit\App\Domain\Entity\SpecialistDocument;

use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Entity\SpecialistDocument\ValueObject\DocumentNumber;
use Codeception\Test\Unit;

/**
 * Class SpecialistDocumentTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\SpecialistDocument
 * @covers  \App\Domain\Entity\SpecialistDocument\SpecialistDocument
 */
class SpecialistDocumentTest extends Unit
{

    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $document = new SpecialistDocument();
        $document->setId(1);
        $document->setName('name');
        $document->setDisciplinesName('discipline');
        $document->setNumber(new DocumentNumber('У12345'));
        $document->setSpecialistId(100666);


        $this->assertEquals(1, $document->getId());
        $this->assertEquals('name', $document->getName());
        $this->assertEquals('discipline', $document->getDisciplinesName());
        $this->assertEquals('У12345', $document->getNumber()->getValue());
        $this->assertEquals(100666, $document->getSpecialistId());
    }
}
