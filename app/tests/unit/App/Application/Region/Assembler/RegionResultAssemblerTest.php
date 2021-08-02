<?php

namespace App\Tests\unit\App\Application\Region\Assembler;

use App\Application\Region\Assembler\RegionResultAssembler;
use App\Application\Region\Dto\RegionResultDto;
use App\Domain\Entity\Region\Region;
use Codeception\TestCase\Test;

/**
 * Class RegionResultAssemblerTest.
 *
 * @package App\Tests\unit\App\Application\Region\Assembler
 *
 * @covers \App\Application\Region\Assembler\RegionResultAssembler
 */
class RegionResultAssemblerTest extends Test
{
    /**
     * @param int    $regionId
     * @param string $regionName
     *
     * @dataProvider regionDataProvider
     */
    public function testAssemble(int $regionId, string $regionName): void
    {
        $assembler = new RegionResultAssembler();
        $region = $this->resolveRegion($regionId, $regionName);

        $regionResultDto = $assembler->assemble($region);

        $this->assertInstanceOf(RegionResultDto::class, $regionResultDto);

        $this->assertEquals($regionId, $regionResultDto->id);
        $this->assertEquals($regionName, $regionResultDto->name);
    }

    /**
     * @return array[]
     */
    public function regionDataProvider()
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
     * @return Region
     */
    public function resolveRegion(int $id, string $name): Region
    {
        $region = new Region();

        $region->setId($id);
        $region->setName($name);

        return $region;
    }
}
