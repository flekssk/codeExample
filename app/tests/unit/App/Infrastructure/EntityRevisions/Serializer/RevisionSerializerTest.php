<?php

namespace App\Tests\unit\App\Infrastructure\EntityRevisions\Serializer;

use App\Domain\Entity\AttestationCommissionMember\AttestationCommissionMember;
use App\Domain\Entity\DocumentTemplate\DocumentTemplate;
use App\Domain\Entity\DocumentType\DocumentType;
use App\Domain\Entity\RegulatoryDocuments\RegulatoryDocuments;
use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Entity\Specialist\SpecialistOccupationType;
use App\Domain\Entity\Specialist\ValueObject\Status;
use App\Domain\Entity\SpecialistWorkSchedule\SpecialistWorkSchedule;
use App\Domain\Entity\ValueObject\Gender;
use Codeception\TestCase\Test;
use App\Infrastructure\EntityRevisions\Configuration;
use App\Infrastructure\EntityRevisions\Serializer\Normalizer\BaseNormalizer;
use App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer\AttestationCommissionMemberNormalizer;
use App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer\DocumentTypeNormalizer;
use App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer\RegulatoryDocumentsNormalizer;
use App\Infrastructure\EntityRevisions\Serializer\Normalizer\EntityNormalizer\SpecialistNormalizer;
use App\Infrastructure\EntityRevisions\Serializer\RevisionsSerializer;
use DateTimeImmutable;

/**
 * Class RevisionSerializerTest.
 *
 * @package App\Tests\unit\App\Infrastructure\EntityRevisions\Serializer
 */
class RevisionSerializerTest extends Test
{
    public function testSerializeEntity(): void
    {
        $entityNormalizers = [
            SpecialistNormalizer::class,
            DocumentTypeNormalizer::class,
            AttestationCommissionMemberNormalizer::class,
            RegulatoryDocumentsNormalizer::class,
        ];
        $configuration = new Configuration(BaseNormalizer::class, $entityNormalizers);

        $serializer = new RevisionsSerializer($configuration);

        $specialist = $this->getSpecialist();
        $documentType = $this->getDocumentType();
        $attestationCommissionMember = $this->getAttestationCommissionMember();
        $regulatoryDocument = $this->getRegulatoryDocuments();

        $serializedSpecialist = $serializer->serialize($specialist);
        $serializedDocumentType = $serializer->serialize($documentType);
        $serializedAttestationCommissionMember = $serializer->serialize($attestationCommissionMember);
        $serializedRegulatoryDocument = $serializer->serialize($regulatoryDocument);

        $this->assertIsString($serializedSpecialist);
        $this->assertIsString($serializedDocumentType);
        $this->assertIsString($serializedAttestationCommissionMember);
        $this->assertIsString($serializedRegulatoryDocument);
    }

    /**
     * @return Specialist
     */
    private function getSpecialist(): Specialist
    {
        $id = 1;
        $gender = new Gender(1);
        $dateOfBirth = new \DateTimeImmutable();

        $region = 'Москва';

        $position = 'test';

        $schedule = new SpecialistWorkSchedule();
        $schedule->setId(1);
        $schedule->setName('test');

        $employmentType = new SpecialistOccupationType();
        $employmentType->setId(1);
        $employmentType->setName('test');

        $status = new Status(1);

        $specialist = new Specialist($id);
        $specialist->setFirstName('Имя');
        $specialist->setSecondName('Фамилия');
        $specialist->setMiddleName('Отчество');
        $specialist->setCompany('Компания');
        $specialist->setGender($gender);
        $specialist->setDateOfBirth($dateOfBirth);
        $specialist->setRegion($region);
        $specialist->setPosition($position);
        $specialist->setSchedule($schedule);
        $specialist->setEmploymentType($employmentType);
        $specialist->setStatus($status);
        $specialist->setCreatedAt(new DateTimeImmutable());

        return $specialist;
    }

    /**
     * @return DocumentType
     */
    private function getDocumentType(): DocumentType
    {
        $dateTime = new DateTimeImmutable();
        $documentTemplate = new DocumentTemplate(
            '1',
            'Диплом',
            'Диплом',
            'Главный бухгалтер',
            new DateTimeImmutable('2020'),
        );
        $documentTemplate->setUpdatedAt(null);
        $imageUrl = 'images/150';

        return new DocumentType(
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
    }

    /**
     * @return AttestationCommissionMember
     */
    private function getAttestationCommissionMember(): AttestationCommissionMember
    {
        $member = new AttestationCommissionMember();
        $member->setId('1');
        $member->setFirstName('First Name');
        $member->setSecondName('Second Name');
        $member->setMiddleName('Middle Name');
        $member->setImageUrl('https://via.placeholder.com/150');
        $member->setDescription('Заместитель директора Департамента развития социального страхования Минтруда России');
        $member->setIsLeader(true);
        $member->setActive(true);
        $member->setUpdatedAt(null);

        return $member;
    }

    /**
     * @return RegulatoryDocuments
     */
    private function getRegulatoryDocuments(): RegulatoryDocuments
    {
        $regulatoryDocument = new RegulatoryDocuments();
        $regulatoryDocument->setId(1);
        $regulatoryDocument->setTitle("title");
        $regulatoryDocument->setUrl("url");
        $regulatoryDocument->setActive(true);
        $regulatoryDocument->setUpdatedAt(null);

        return $regulatoryDocument;
    }
}
