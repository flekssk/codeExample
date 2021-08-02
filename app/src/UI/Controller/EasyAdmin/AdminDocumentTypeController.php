<?php

namespace App\UI\Controller\EasyAdmin;

use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Repository\DocumentTemplate\DocumentTemplateRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use DateTimeImmutable;

/**
 * Class AdminDocumentTypeController.
 *
 * @package App\UI\Controller\EasyAdmin
 */
class AdminDocumentTypeController extends EasyAdminController
{
    /**
     * @var DocumentTemplateRepositoryInterface
     */
    private DocumentTemplateRepositoryInterface $documentTemplateRepository;

    /**
     * AdminDocumentTypeController constructor.
     *
     * @param DocumentTemplateRepositoryInterface $documentTemplateRepository
     */
    public function __construct(DocumentTemplateRepositoryInterface $documentTemplateRepository)
    {
        $this->documentTemplateRepository = $documentTemplateRepository;
    }

    /**
     * @return DocumentType
     */
    protected function createNewEntity(): DocumentType
    {
        $dateTime = new DateTimeImmutable();
        $documentTemplates = $this->documentTemplateRepository->findAll();

        return new DocumentType(
            0,
            '',
            reset($documentTemplates),
            '',
            true,
            '',
            '',
            $dateTime,
            null,
        );
    }
}
