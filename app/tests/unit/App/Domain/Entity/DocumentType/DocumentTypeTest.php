<?php

namespace App\Tests\unit\App\Domain\Entity\DocumentType;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\ValueObject\ImageUrl;
use Codeception\Test\Unit;
use DateTimeImmutable;

/**
 * Class DocumentTypeTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\DocumentType
 * @covers  \App\Domain\Entity\DocumentType\DocumentType
 */
class DocumentTypeTest extends Unit
{
    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $dateTime = new DateTimeImmutable();
        $documentTemplate = new DocumentTemplate(
            '1',
            'Диплом',
            'Диплом',
            'Главный бухгалтер',
            new DateTimeImmutable('2020'),
        );
        $imageUrl = 'images/150';

        $document = new DocumentType(
            0,
            'Name',
            $documentTemplate,
            'Template Name',
            true,
            $imageUrl,
            $imageUrl,
            $dateTime,
            $dateTime,
        );

        $this->assertEquals('Name', $document->getName());
        $this->assertEquals($documentTemplate, $document->getDocumentTemplate());
        $this->assertEquals(true, $document->isActive());
        $this->assertEquals($imageUrl, $document->getImagePreview());
        $this->assertEquals($imageUrl, $document->getImageBackground());
        $this->assertEquals($dateTime, $document->getCreatedAt());
        $this->assertEquals($dateTime, $document->getUpdatedAt());
    }
}
