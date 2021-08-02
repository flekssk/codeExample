<?php

declare(strict_types=1);

namespace App\Domain\Service\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Repository\Product\ProductRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Repository\SpecialistAccess\SpecialistAccessRepositoryInterface;
use App\Domain\Repository\SpecialistDocument\SpecialistDocumentRepositoryInterface;
use App\Infrastructure\HttpClients\Id2\Id2ProductsClientInterface;

class SpecialistStatusCalcService implements SpecialistStatusCalcServiceInterface
{
    private const DOCUMENT_INTERVAL = 'P3M';
    private const UPDATE_INTERVAL = 'P1D';

    /** @var SpecialistAccessRepositoryInterface */
    private SpecialistAccessRepositoryInterface $accessRepository;

    /** @var SpecialistDocumentRepositoryInterface */
    private SpecialistDocumentRepositoryInterface $documentRepository;

    /** @var SpecialistRepositoryInterface */
    private SpecialistRepositoryInterface $specialistRepository;

    /** @var Id2ProductsClientInterface */
    private Id2ProductsClientInterface $id2ProductsClient;

    /** @var ProductRepositoryInterface  */
    private ProductRepositoryInterface $productRepository;

    /**
     * SpecialistStatusCalcService constructor.
     *
     * @param SpecialistAccessRepositoryInterface   $accessRepository
     * @param SpecialistDocumentRepositoryInterface $documentRepository
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param ProductRepositoryInterface $productRepository
     * @param Id2ProductsClientInterface $id2ProductsClient
     */
    public function __construct(
        SpecialistAccessRepositoryInterface $accessRepository,
        SpecialistDocumentRepositoryInterface $documentRepository,
        SpecialistRepositoryInterface $specialistRepository,
        ProductRepositoryInterface $productRepository,
        Id2ProductsClientInterface $id2ProductsClient
    ) {
        $this->accessRepository = $accessRepository;
        $this->documentRepository = $documentRepository;
        $this->specialistRepository = $specialistRepository;
        $this->productRepository = $productRepository;
        $this->id2ProductsClient = $id2ProductsClient;
    }

    /**
     * @inheritDoc
     */
    public function calcStatus(Specialist $specialist): Status
    {
        $this->updateAccesses($specialist);

        $documents = $this->documentRepository->findAllBySpecialistId($specialist->getId());
        $accesses = $this->accessRepository->findAllBySpecialistId($specialist->getId());
        $hasAccess = $this->hasAccess($accesses);
        $hasDocumentForInterval = $this->hasDocumentForInterval($documents);

        $currentStatus = $specialist->getStatus();
        $newStatus = new Status(Status::STATUS_CERTIFICATION_REQUIRED);

        if ($hasAccess && !$hasDocumentForInterval) {
            $newStatus = new Status(Status::STATUS_STUDYING);
        } elseif ($hasDocumentForInterval) {
            $newStatus = new Status(Status::STATUS_CERTIFIED);
        }

        // Статус "Проходит обучение" меняется только в том случае, если он меняется на "Аттестованный".
        $studyingStatus = new Status(Status::STATUS_STUDYING);
        $certifiedStatus = new Status(Status::STATUS_CERTIFIED);
        if ($currentStatus->isEqual($studyingStatus) && !$newStatus->isEqual($certifiedStatus)) {
            $newStatus = $currentStatus;
        }

        if ($currentStatus->isEqual($newStatus) === false) {
            $specialist->setStatus($newStatus);
            $this->specialistRepository->save($specialist);
        }

        return $newStatus;
    }

    /**
     * @param SpecialistAccess[] $accesses
     *
     * @return bool
     */
    private function hasAccess(array $accesses): bool
    {
        return !empty($accesses);
    }

    /**
     * @param SpecialistDocument[] $documents
     *
     * @return bool
     */
    private function hasDocumentForInterval(array $documents): bool
    {
        $filterDocuments = array_filter(
            $documents,
            static function ($document) {
                $today = new \DateTimeImmutable();
                return $document->getEndDate() > $today->add(new \DateInterval(self::DOCUMENT_INTERVAL));
            }
        );

        return !empty($filterDocuments);
    }

    private function updateAccesses(Specialist $specialist): void
    {
        $accesses = $this->id2ProductsClient->getAccesses($specialist->getId());
        $products = $this->productRepository->findAllIds();
        $products = array_combine($products, $products);
        $this->accessRepository->deleteBySpecialistId($specialist->getId());
        foreach ($accesses as $access) {
            if (array_key_exists($access->getProductId(), $products)) {
                $this->accessRepository->save($access);
            }
        }

        $specialist->setDateCheckAccess(new \DateTimeImmutable());
        $this->specialistRepository->save($specialist);
    }
}
