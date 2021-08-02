<?php

namespace App\Tests\integrational\App\Application\School\SchoolSync;

use App\Application\School\SchoolSync\Resolver\SchoolSyncResolver;
use App\Application\School\SchoolSync\SchoolSyncService;
use App\Domain\Repository\School\SchoolRepositoryInterface;
use App\Infrastructure\HttpClients\School\Assembler\SchoolResponseAssembler;
use App\Infrastructure\HttpClients\School\Client\SchoolClientDummy;
use App\Infrastructure\HttpClients\School\SchoolService;
use App\Infrastructure\Persistence\Doctrine\Repository\School\SchoolRepository;
use Codeception\Exception\ModuleException;
use Codeception\Module\Symfony;
use Codeception\TestCase\Test;

/**
 * Class SchoolSyncServiceTest.
 *
 * @package App\Tests\integrational\App\Application\School\SchoolSync
 * @covers \App\Application\School\SchoolSync\SchoolSyncService
 */
class SchoolSyncServiceTest extends Test
{
    /**
     * Test sync should import data.
     */
    public function testSyncShouldImportData(): void
    {
        /** @var SchoolRepositoryInterface $schoolRepository */
        $schoolRepository =  $this->getService(SchoolRepository::class);

        $syncService = new SchoolSyncService(
            new SchoolService(
                new SchoolClientDummy(),
                new SchoolResponseAssembler()
            ),
            $schoolRepository,
            new SchoolSyncResolver()
        );
        $syncService->sync();

        $school = $schoolRepository->findById('20');

        $this->assertEquals('20', $school->getId());
        $this->assertEquals('Test 20', $school->getName());

        $school = $schoolRepository->findById('22');

        $this->assertEquals('22', $school->getId());
        $this->assertEquals('По умолчанию', $school->getName());
    }

    /**
     * @param string $class
     *
     * @return object|null
     * @throws ModuleException
     */
    public function getService(string $class)
    {
        /** @var Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get($class);
    }
}
