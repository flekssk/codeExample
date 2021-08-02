<?php

namespace App\Tests\unit\App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Assembler\SiteOptionResultAssembler;
use App\Application\SiteOption\Dto\SiteOptionResultDto;
use App\Domain\Entity\SiteOption;
use Codeception\Test\Unit;

/**
 * Class SiteOptionResultAssemblerTest.
 *
 * @package App\Tests\unit\App\Application\SiteOption\Assembler
 *
 * @covers \App\Application\SiteOption\Assembler\SiteOptionResultAssembler
 */
class SiteOptionResultAssemblerTest extends Unit
{
    /**
     * @dataProvider siteOptionsDataProvider
     * @covers       \App\Application\SiteOption\Assembler\SiteOptionResultAssembler::assemble()
     *
     * @param SiteOption $siteOption
     */
    public function testAssemble(SiteOption $siteOption): void
    {
        $siteOptionResultAssembler = new SiteOptionResultAssembler();

        $siteOptionResultDto = $siteOptionResultAssembler->assemble($siteOption);

        $this->assertInstanceOf(SiteOptionResultDto::class, $siteOptionResultDto);
        $this->assertEquals($siteOption->getName(), $siteOptionResultDto->name);
        $this->assertEquals($siteOption->getValue(), $siteOptionResultDto->value);
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
