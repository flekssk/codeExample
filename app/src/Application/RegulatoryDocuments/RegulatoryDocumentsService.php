<?php

declare(strict_types=1);

namespace App\Application\RegulatoryDocuments;

use App\Application\RegulatoryDocuments\Assembler\RegulatoryDocumentsAssembler;
use App\Application\RegulatoryDocuments\Dto\RegulatoryDocumentsDto;
use App\Domain\Repository\RegulatoryDocuments\RegulatoryDocumentsRepositoryInterface;

/**
 * Class RegulatoryDocumentsService.
 *
 * @package App\Application\RegulatoryDocuments
 */
class RegulatoryDocumentsService
{
    /**
     * @var RegulatoryDocumentsRepositoryInterface
     */
    private RegulatoryDocumentsRepositoryInterface $repository;

    /**
     * @var RegulatoryDocumentsAssembler
     */
    private RegulatoryDocumentsAssembler $assembler;

    /**
     * RegulatoryDocumentsService constructor.
     *
     * @param RegulatoryDocumentsRepositoryInterface $repository
     * @param RegulatoryDocumentsAssembler $assembler
     */
    public function __construct(
        RegulatoryDocumentsRepositoryInterface $repository,
        RegulatoryDocumentsAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @return RegulatoryDocumentsDto[]
     */
    public function getRegulatoryDocuments(): array
    {
        $regulatoryDocumentsDto = [];
        $regulatoryDocuments = $this->repository->findAllActiveDocuments();
        foreach ($regulatoryDocuments as $regulatoryDocument) {
            $regulatoryDocumentsDto[] = $this->assembler->assemble($regulatoryDocument);
        }

        return $regulatoryDocumentsDto;
    }
}
