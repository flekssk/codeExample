<?php

namespace App\Tests\unit\App\Domain\Entity\DocumentTemplate;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use Codeception\Test\Unit;
use DateTimeImmutable;

/**
 * Class DocumentTemplateTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\DocumentTemplate
 * @covers  \App\Domain\Entity\DocumentTemplate\DocumentTemplate
 */
class DocumentTemplateTest extends Unit
{

    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $year = new DateTimeImmutable('2020');
        $document = new DocumentTemplate(
            '12345',
            'Name',
            'Type',
            'Discipline Name',
            $year
        );

        $this->assertEquals('12345', $document->getId());
        $this->assertEquals('Name', $document->getName());
        $this->assertEquals('Type', $document->getDocumentType());
        $this->assertEquals('Discipline Name', $document->getDisciplinesName());
        $this->assertEquals($year, $document->getYear());
    }
}
