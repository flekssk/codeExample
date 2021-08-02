<?php

namespace App\Tests\integrational\Application\Specialist\SpecialistOccupationType;

use Codeception\TestCase\Test;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use App\Application\Specialist\SpecialistOccupationType\SpecialistOccupationTypeService;
use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;
use App\Infrastructure\Persistence\Doctrine\Repository\Specialist\SpecialistOccupationTypeRepository;

/**
 * Class SpecialistOccupationTypeServiceTest.
 */
class SpecialistOccupationTypeServiceTest extends Test
{

    /**
     * Check find data from service.
     */
    public function testCheckFindAllMethod()
    {
        $assembler = new SpecialistOccupationTypeResultAssembler();
        $repository = $this->getRepository();
        $service = new SpecialistOccupationTypeService($assembler, $repository);
        $data = $service->getAll();
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertTrue($data[0] instanceof SpecialistOccupationTypeResultDto);
    }

    /**
     * @return SpecialistOccupationTypeRepository
     * @throws \Codeception\Exception\ModuleException
     */
    private function getRepository(): SpecialistOccupationTypeRepository
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(SpecialistOccupationTypeRepository::class);
    }
}
