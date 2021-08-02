<?php

namespace App\Tests\unit\App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Assembler\SiteOptionListResultAssembler;
use App\Application\SiteOption\Assembler\SiteOptionResultAssembler;
use App\Application\SiteOption\Dto\SiteOptionListResultDto;
use App\Domain\Entity\SiteOption;
use Codeception\Test\Unit;

/**
 * Class SiteOptionListResultAssemblerTest.
 *
 * @covers \App\Application\SiteOption\Assembler\SiteOptionListResultAssembler
 */
class SiteOptionListResultAssemblerTest extends Unit
{
    /**
     * @covers       \App\Application\SiteOption\Assembler\SiteOptionListResultAssembler::assemble
     * @dataProvider siteOptionsDataProvider
     *
     * @param SiteOption $option
     */
    public function testAssemble(SiteOption $option)
    {
        $siteOptionResultAssembler = new SiteOptionResultAssembler();
        $assembler = new SiteOptionListResultAssembler($siteOptionResultAssembler);

        $siteOptionResultDto = $assembler->assemble([$option]);

        $this->assertInstanceOf(SiteOptionListResultDto::class, $siteOptionResultDto);
        $this->assertCount(1, $siteOptionResultDto->options);
    }

    /**
     * @return SiteOption[]
     */
    public function siteOptionsDataProvider(): array
    {
        $option = new SiteOption('test');

        $option->setValue('test');

        return [
            [
                $option,
            ],
        ];
    }
}
