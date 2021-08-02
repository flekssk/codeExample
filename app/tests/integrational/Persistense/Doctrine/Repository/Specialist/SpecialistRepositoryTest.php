<?php

declare(strict_types=1);

namespace App\Tests\integrational\infrastructure\Persistense\Doctrine\Repository\Specialist;

use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use Codeception\TestCase\Test;

/**
 * Class SpecialistRepositoryTest.
 *
 * @package App\Tests\integrational\infrastructure\Persistense\Doctrine\Repository\News
 *
 * @covers \App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository
 */
class SpecialistRepositoryTest extends Test
{
    /**
     * Test get count.
     */
    public function testGetCount()
    {
        $repository = $this->createRepository();

        $this->assertIsInt($repository->count([]));
    }

    /**
     * @return SpecialistRepository
     * @throws \Codeception\Exception\ModuleException
     */
    private function createRepository(): SpecialistRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');

        $container = $module->kernel->getContainer();

        return $container->get(SpecialistRepository::class);
    }
}
