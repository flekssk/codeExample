<?php

namespace App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Dto\SiteOptionListResultDto;
use App\Domain\Entity\SiteOption;

/**
 * Interface SiteOptionListResultAssemblerInterface.
 *
 * @package App\Application\SiteOption\Assembler
 */
interface SiteOptionListResultAssemblerInterface
{
    /**
     * @param SiteOption[] $options
     *
     * @return SiteOptionListResultDto
     */
    public function assemble(array $options): SiteOptionListResultDto;
}
