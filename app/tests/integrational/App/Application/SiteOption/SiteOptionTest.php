<?php

namespace App\Tests\integrational\App\Application\SiteOption;

use App\Domain\Entity\SiteOption;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\SiteOptionRepository;
use Codeception\TestCase\Test;
use DateTimeInterface;

/**
 * Class SiteOptionTest.
 *
 * @covers \App\Domain\Entity\SiteOption
 * @covers \App\Infrastructure\EventSubscriber\EntityEventSubscriber
 */
class SiteOptionTest extends Test
{
    /**
     * Check createdAt field not empty.
     */
    public function testCheckCreatedAtFieldNotEmpty()
    {
        $repository = $this->getRepository();

        $siteOption = new SiteOption('test_name');
        $repository->save($siteOption);

        $entity = $repository->findOneByName('test_name');
        $createdAt = $entity->getCreatedAt();

        $this->assertInstanceOf(DateTimeInterface::class, $createdAt);
    }

    /**
     * Check updatedAt field not empty after entity update.
     */
    public function testCheckUpdatedAtFieldNotEmptyAfterEntityUpdate()
    {
        $repository = $this->getRepository();

        $siteOption = $repository->findOneByName('mainPageText');
        $siteOption->setValue('test');
        $repository->save($siteOption);

        $entity = $repository->findOneByName('mainPageText');
        $updatedAt = $entity->getUpdatedAt();

        $this->assertInstanceOf(DateTimeInterface::class, $updatedAt);
    }

    /**
     * @return SiteOptionRepositoryInterface
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): SiteOptionRepositoryInterface
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SiteOptionRepository::class);
    }
}
