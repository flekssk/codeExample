<?php

namespace App\Application\Specialist\SpecialistOccupationType\Assembler;

use App\Domain\Entity\Specialist\SpecialistOccupationType;
use App\Application\Specialist\SpecialistOccupationType\Dto\SpecialistOccupationTypeResultDto;
use App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler;
use Codeception\TestCase\Test;

/**
 * Class SpecialistOccupationTypeResultAssemblerTest.
 *
 * @package App\Application\Specialist\SpecialistOccupationType\Assembler
 *
 * @covers \App\Application\Specialist\SpecialistOccupationType\Assembler\SpecialistOccupationTypeResultAssembler
 */
class SpecialistOccupationTypeResultAssemblerTest extends Test
{

    /**
     * @param int    $id
     * @param string $name
     *
     * @dataProvider typeDataProvider
     */
    public function testAssemble(int $id, string $name): void
    {
        $assembler = new SpecialistOccupationTypeResultAssembler();
        $type = $this->resolveSpecialistOccupationType($id, $name);

        $typeResultDto = $assembler->assemble($type);

        $this->assertInstanceOf(SpecialistOccupationTypeResultDto::class, $typeResultDto);

        $this->assertEquals($id, $typeResultDto->id);
        $this->assertEquals($name, $typeResultDto->name);
    }

    /**
     * @return array[]
     */
    public function typeDataProvider()
    {
        return [
            [
                1,
                'test',
            ],
        ];
    }

    /**
     * @param int    $id
     * @param string $name
     *
     * @return SpecialistOccupationType
     */
    public function resolveSpecialistOccupationType(int $id, string $name): SpecialistOccupationType
    {
        $type = new SpecialistOccupationType();

        $type->setId($id);
        $type->setName($name);

        return $type;
    }
}
