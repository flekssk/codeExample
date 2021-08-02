<?php

namespace App\Infrastructure\HttpClients\CrmApi;

use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;

/**
 * Interface CrmApiInterface.
 */
interface CrmApiInterface
{
    /**
     * @param string $registryDomain
     *
     * @return array
     */
    public function getProducts(string $registryDomain): array;

    /**
     * @param int[] $versionNumbers
     * @param \DateTimeImmutable $onlyAfterDate
     *
     * @return SpecialistDocument[]
     */
    public function getDocuments(array $versionNumbers, \DateTimeImmutable $onlyAfterDate): array;

    /**
     * @param int $specialistId
     *
     * @return SpecialistDocument[]
     */
    public function getDocumentsForSpecialistId(int $specialistId): array;

    /**
     * @return DocumentTemplate[]
     */
    public function getDocumentTemplates(): array;
}
