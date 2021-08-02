<?php

namespace App\Tests\integrational\App\Application\Skill\SkillSync;

use App\Application\Skill\SkillSync\Resolver\SkillSyncResolver;
use App\Application\Skill\SkillSync\SkillSyncService;
use App\Application\Skill\SkillSync\SkillSyncServiceInterface;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Domain\Repository\Skill\SkillRepositoryInterface;
use App\Infrastructure\HttpClients\Skills\Assembler\SkillsResponseAssembler;
use App\Infrastructure\HttpClients\Skills\SkillsClientDummy;
use App\Infrastructure\HttpClients\Skills\SkillsService;
use App\Infrastructure\Persistence\Doctrine\Repository\SiteOptionRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\Skill\SkillRepository;
use Codeception\Exception\ModuleException;
use Codeception\Module\Symfony;
use Codeception\TestCase\Test;

/**
 * Class SkillSyncServiceTest.
 *
 * @package App\Tests\integrational\App\Application\Skill\SkillSync
 * @covers \App\Application\Skill\SkillSync\SkillSyncService
 */
class SkillSyncServiceTest extends Test
{
    /**
     * Test sync should import data.
     */
    public function testSyncShouldImportData(): void
    {
        /** @var SkillRepositoryInterface $skillRepository */
        $skillRepository =  $this->getService(SkillRepository::class);
        /** @var SiteOptionRepositoryInterface $siteOptionsRepository */
        $siteOptionsRepository =  $this->getService(SiteOptionRepository::class);

        /** @var SkillSyncServiceInterface $syncService */
        $syncService = new SkillSyncService(
            new SkillsService(
                new SkillsClientDummy(),
                new SkillsResponseAssembler()
            ),
            $skillRepository,
            new SkillSyncResolver(),
            $siteOptionsRepository
        );
        $syncService->sync();

        $skill = $skillRepository->findById('14');

        $this->assertEquals('14', $skill->getId());
        $this->assertEquals('Test', $skill->getName());
        $this->assertEquals('1da80835-8566-4f43-a722-fa83af8223ef', $skill->getMacroSkillId());
        $this->assertEquals('Бухгалтерский и налоговый учет, отчетность', $skill->getMacroSkillName());
        $this->assertEquals('915db6b8-0d33-4c21-a2ba-2fcbee1d88ee', $skill->getMacroTypeId());
        $this->assertEquals('Профессиональный рост', $skill->getMacroTypeName());
        $this->assertEquals('acb8e49a-c541-4311-9e29-c44917014a07', $skill->getReestrId());
        $this->assertEquals('Бухгалтерия коммерческая', $skill->getReestrName());
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
