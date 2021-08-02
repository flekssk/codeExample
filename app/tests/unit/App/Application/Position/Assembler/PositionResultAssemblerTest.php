<?php

namespace App\Tests\unit\App\Application\Position\Assembler;

use App\Application\Position\Assembler\PositionResultAssembler;
use App\Application\Position\Dto\PositionResultDto;
use App\Domain\Entity\Position\Position;
use Codeception\TestCase\Test;

/**
 * Class PositionResultAssemblerTest.
 *
 * @package App\Tests\unit\App\Application\Position\Assembler
 *
 * @covers \App\Application\Position\Assembler\PositionResultAssembler
 */
class PositionResultAssemblerTest extends Test
{
    /**
     * @dataProvider positionDataProvider
     *
     * @param int $positionId
     * @param     $positionName
     */
    public function testAssemble(int $positionId, string $positionName)
    {
        $assembler = new PositionResultAssembler();

        $position = $this->resolvePosition($positionId, $positionName);

        $positionResultDto = $assembler->assemble($position);

        $this->assertInstanceOf(PositionResultDto::class, $positionResultDto);

        $this->assertEquals($positionId, $positionResultDto->id);
        $this->assertEquals($positionName, $positionResultDto->name);
    }

    /**
     * @return array[]
     */
    public function positionDataProvider()
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
     * @return Position
     */
    private function resolvePosition(int $id, string $name)
    {
        $position = new Position();

        $position->setId($id);
        $position->setName($name);

        return $position;
    }
}
