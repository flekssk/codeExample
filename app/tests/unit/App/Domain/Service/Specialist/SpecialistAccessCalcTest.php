<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Service\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use App\Domain\Entity\SpecialistDocument\SpecialistDocument;
use App\Domain\Service\Specialist\SpecialistStatusCalcService;
use App\Infrastructure\HttpClients\Id2\Id2ProductsClient;
use App\Infrastructure\Persistence\Doctrine\Repository\Product\ProductRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistAccess\SpecialistAccessRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistDocument\SpecialistDocumentRepository;
use Codeception\Test\Unit;
use Codeception\Util\Stub;
use phpDocumentor\Reflection\Types\Void_;

/**
 * Class SpecialistAccessCalcTest
 * @package App\Tests\unit\App\Domain\Service\Specialist
 */
class SpecialistAccessCalcTest extends Unit
{
    /**
     * @throws \Exception
     */
    public function testServiceWithNoDocumentsAndNoAccessesShouldReturnCertificationRequiredStatus(): void
    {
        $specialistId = 1;
        $service = $this->getServiceWithNoDocumentsAndNoAccesses();
        $specialist = new Specialist($specialistId);
        $requiredStatus = new Status(Status::STATUS_CERTIFICATION_REQUIRED);
        $specialist->setStatus($requiredStatus);
        $specialist->setDateCheckAccess(null);

        $resultStatus = $service->calcStatus($specialist);

        $this->assertEquals($resultStatus, $requiredStatus);
    }

    /**
     * @throws \Exception
     */
    public function testServiceWithDocumentsAndNoAccessesShouldReturnCertifiedStatus(): void
    {
        $specialistId = 1;
        $service = $this->getServiceWithDocumentsAndNoAccesses($specialistId);
        $specialist = new Specialist($specialistId);
        $requiredStatus = new Status(Status::STATUS_CERTIFIED);
        $specialist->setStatus($requiredStatus);
        $specialist->setDateCheckAccess(null);

        $resultStatus = $service->calcStatus($specialist);

        $this->assertEquals($resultStatus, $requiredStatus);
    }

    /**
     * @throws \Exception
     */
    public function testServiceWithNoDocumentsAndAccessesShouldReturnStudyingStatus(): void
    {
        $specialistId = 1;
        $service = $this->getServiceWithNoDocumentsAndAccesses($specialistId);
        $specialist = new Specialist($specialistId);
        $requiredStatus = new Status(Status::STATUS_STUDYING);
        $specialist->setStatus($requiredStatus);
        $specialist->setDateCheckAccess(null);

        $resultStatus = $service->calcStatus($specialist);

        $this->assertEquals($resultStatus, $requiredStatus);
    }

    /**
     * @return SpecialistStatusCalcService
     * @throws \Exception
     */
    private function getServiceWithNoDocumentsAndNoAccesses(): SpecialistStatusCalcService
    {
        return new SpecialistStatusCalcService(
            Stub::make(
                SpecialistAccessRepository::class,
                ['findAllBySpecialistId' => [], 'deleteBySpecialistId' => null]
            ),
            Stub::make(SpecialistDocumentRepository::class, ['findAllBySpecialistId' => []]),
            Stub::make(SpecialistRepository::class, ['save' => null]),
            Stub::make(ProductRepository::class, ['findAllIds' => []]),
            Stub::make(Id2ProductsClient::class, ['getAccesses' => []])
        );
    }

    /**
     * @param int $specialistId
     *
     * @return SpecialistStatusCalcService
     * @throws \Exception
     */
    private function getServiceWithDocumentsAndNoAccesses(int $specialistId): SpecialistStatusCalcService
    {
        $document = new SpecialistDocument();
        $document->setSpecialistId($specialistId);
        $date = new \DateTime();
        $document->setEndDate($date->add(new \DateInterval('P4M')));

        return new SpecialistStatusCalcService(
            Stub::make(
                SpecialistAccessRepository::class,
                ['findAllBySpecialistId' => [], 'deleteBySpecialistId' => null]
            ),
            Stub::make(SpecialistDocumentRepository::class, ['findAllBySpecialistId' => [$document]]),
            Stub::make(SpecialistRepository::class, ['save' => null]),
            Stub::make(ProductRepository::class, ['findAllIds' => []]),
            Stub::make(Id2ProductsClient::class, ['getAccesses' => []])
        );
    }

    /**
     * @param int $specialistId
     *
     * @return SpecialistStatusCalcService
     * @throws \Exception
     */
    private function getServiceWithNoDocumentsAndAccesses(int $specialistId): SpecialistStatusCalcService
    {
        $access = new SpecialistAccess();
        $access->setSpecialistId($specialistId);
        $productId = 1;
        $access->setProductId($productId);

        return new SpecialistStatusCalcService(
            Stub::make(
                SpecialistAccessRepository::class,
                ['findAllBySpecialistId' => [$access], 'deleteBySpecialistId' => null, 'save' => null]
            ),
            Stub::make(SpecialistDocumentRepository::class, ['findAllBySpecialistId' => []]),
            Stub::make(SpecialistRepository::class, ['save' => null]),
            Stub::make(ProductRepository::class, ['findAllIds' => [$productId]]),
            Stub::make(Id2ProductsClient::class, ['getAccesses' => [$access]])
        );
    }
}
