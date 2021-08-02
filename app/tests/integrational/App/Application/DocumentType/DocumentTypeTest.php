<?php

namespace App\Tests\integrational\App\Application\DocumentType;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\ValueObject\ImageUrl;
use App\Infrastructure\Persistence\Doctrine\Repository\DocumentTemplate\DocumentTemplateRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\DocumentType\DocumentTypeRepository;
use Codeception\Exception\ModuleException;
use Codeception\TestCase\Test;
use DateTimeImmutable;

/**
 * Class DocumentTypeTest.
 *
 * @covers \App\Infrastructure\Persistence\Doctrine\Repository\DocumentType\DocumentTypeRepository
 */
class DocumentTypeTest extends Test
{
    /**
     * Check DocumentType entity creation.
     */
    public function testCheckDocumentTypeEntityCreation()
    {
        $documentTypeRepository = $this->getRepository(DocumentTypeRepository::class);
        $documentTemplateRepository = $this->getRepository(DocumentTemplateRepository::class);

        $dateTime = new DateTimeImmutable();
        $documentTemplate = $documentTemplateRepository->find('d47dcfaa-3676-e911-bba0-00155d627f03');
        $imageUrl = 'images/150';

        $documentType = new DocumentType(
            0,
            'TestName',
            $documentTemplate,
            'Template Name',
            true,
            $imageUrl,
            $imageUrl,
            $dateTime,
            $dateTime,
        );

        $documentTypeRepository->save($documentType);

        $result = $documentTypeRepository->findBy(['name' => 'TestName']);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(DocumentType::class, $result[0]);
    }

    /**
     * @return object
     * @throws ModuleException
     */
    private function getRepository(string $repositoryClass): object
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get($repositoryClass);
    }
}
