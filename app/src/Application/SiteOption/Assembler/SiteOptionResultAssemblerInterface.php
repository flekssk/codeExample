<?php

declare(strict_types=1);

namespace App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Dto\SiteOptionResultDto;
use App\Domain\Entity\SiteOption;

/**
 * Class SiteOptionResultAssemblerInterface.
 *
 * @package App\Application\SiteOption\Assembler
 */
interface SiteOptionResultAssemblerInterface
{
    /**
     * @param SiteOption $option
     *
     * @return SiteOptionResultDto
     */
    public function assemble(SiteOption $option): SiteOptionResultDto;
}
