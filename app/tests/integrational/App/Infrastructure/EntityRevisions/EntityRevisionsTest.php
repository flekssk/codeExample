<?php

namespace App\Tests\integrational\App\Infrastructure\EntityRevisions;

use App\Domain\Entity\EntityRevision\EntityRevision;
use App\Domain\Entity\Specialist\Specialist;
use App\Infrastructure\Persistence\Doctrine\Repository\EntityRevision\EntityRevisionRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use Codeception\Exception\ModuleException;
use Codeception\Module\Symfony;
use Codeception\Test\Unit;

/**
 * Class CrmProxyTest.
 *
 * @covers \App\Infrastructure\HttpClients\Crm\CrmProxy
 */
class EntityRevisionsTest extends Unit
{

    /**
     * Check creation of EntityRevision.
     */
    public function testCheckCreationOfEntityRevision()
    {
        $companyValue = 'test company';

        $specialistRepository = $this->createRepository(SpecialistRepository::class);
        /** @var Specialist $specialist */
        $specialist = $specialistRepository->find(1);
        $specialist->setCompany($companyValue);
        $specialistRepository->save($specialist);

        $entityRevisionRepository = $this->createRepository(EntityRevisionRepository::class);
        $entityRevision = $entityRevisionRepository->findOneBy(['entityId' => $specialist->getId()]);

        $content = json_decode($entityRevision->getContent(), true);

        $this->assertInstanceOf(EntityRevision::class, $entityRevision);
        $this->assertIsInt($entityRevision->getId());
        $this->assertIsInt($entityRevision->getEntityId());
        $this->assertEquals($specialist->getId(), $entityRevision->getEntityId());
        $this->assertIsString($entityRevision->getContent());
        $this->assertJson($entityRevision->getContent());
        $this->assertEquals(EntityRevision::OPERATION_UPDATE, $entityRevision->getOperation());
        $this->assertEquals($content['company'], $companyValue);
    }

    /**
     * @param string $class
     *
     * @return object
     *
     * @throws ModuleException
     */
    private function createRepository(string $class): object
    {
        /** @var Symfony $module */
        $module = $this->getModule('Symfony');

        $container = $module->kernel->getContainer();

        return $container->get($class);
    }
}
