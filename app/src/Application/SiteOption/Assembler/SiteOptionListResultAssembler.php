<?php

namespace App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Dto\SiteOptionListResultDto;
use App\Application\SiteOption\Dto\SiteOptionResultDto;

/**
 * Class SiteOptionListResultAssembler.
 *
 * @package App\Application\SiteOption\Assembler
 */
class SiteOptionListResultAssembler implements SiteOptionListResultAssemblerInterface
{
    /**
     * @var SiteOptionResultAssembler
     */
    private SiteOptionResultAssembler $siteOptionResultAssembler;

    public function __construct(SiteOptionResultAssembler $siteOptionResultAssembler)
    {
        $this->siteOptionResultAssembler = $siteOptionResultAssembler;
    }

    /**
     * @inheritDoc
     */
    public function assemble(array $options): SiteOptionListResultDto
    {
        $siteOptionsListResultDto = new SiteOptionListResultDto();
        $optionsResultDto = [];

        foreach ($options as $option) {
            $optionsResultDto[] = $this->siteOptionResultAssembler->assemble($option);
        }

        $siteOptionsListResultDto->options = $optionsResultDto;

        return $siteOptionsListResultDto;
    }
}
