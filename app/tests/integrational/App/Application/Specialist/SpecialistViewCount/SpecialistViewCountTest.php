<?php

namespace App\Tests\integrational\App\Application\Specialist\SpecialistViewCount;

use App\Application\Specialist\SpecialistViewCount\SpecialistViewCount;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistRepository;
use Codeception\TestCase\Test;

/**
 * Class SpecialistViewCountTest.
 *
 * @package App\Tests\integrational\Application\SpecialistWorkSchedule
 */
class SpecialistViewCountTest extends Test
{
    /**
     * Check that increment works properly.
     */
    public function testIncrement()
    {
        $repository = $this->getRepository();

        $service = new SpecialistViewCount($repository);
        $service->increment(13);

        $specialist = $repository->get(13);

        $this->assertEquals(1, $specialist->getViewCount());
    }

    /**
     * @return SpecialistRepository
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): SpecialistRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SpecialistRepository::class);
    }
}
