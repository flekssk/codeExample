<?php

namespace App\Tests\integrational\Application\SpecialistWorkSchedule;

use Codeception\TestCase\Test;
use App\Application\SpecialistWorkSchedule\SpecialistWorkScheduleService;
use App\Application\SpecialistWorkSchedule\Assembler\SpecialistWorkScheduleResultAssembler;
use App\Application\SpecialistWorkSchedule\Dto\SpecialistWorkScheduleResultDto;
use App\Infrastructure\Persistence\Doctrine\Repository\SpecialistWorkSchedule\SpecialistWorkScheduleRepository;

/**
 * Description of SpecialistWorkScheduleServiceTest
 *
 * @author sergeys
 */
class SpecialistWorkScheduleServiceTest extends Test
{

    /**
     * Check find data from service.
     */
    public function testCheckFindAllMethod()
    {
        $assembler = new SpecialistWorkScheduleResultAssembler();
        $repository = $this->getRepository();
        $service = new SpecialistWorkScheduleService($assembler, $repository);
        $data = $service->getAll();
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertTrue($data[0] instanceof SpecialistWorkScheduleResultDto);
    }

    /**
     * @return SpecialistWorkScheduleRepository
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): SpecialistWorkScheduleRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SpecialistWorkScheduleRepository::class);
    }
}
