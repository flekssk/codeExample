<?php

declare(strict_types=1);

namespace App\Application\SiteOption\Assembler;

use App\Application\SiteOption\Dto\SiteOptionResultDto;
use App\Domain\Entity\SiteOption;

/**
 * Class SiteOptionResultAssembler.
 *
 * @package App\Application\SiteOption\Assembler
 */
class SiteOptionResultAssembler implements SiteOptionResultAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(SiteOption $option): SiteOptionResultDto
    {
        $dto = new SiteOptionResultDto();

        $dto->value = $option->getValue();
        $dto->name = $option->getName();

        return $dto;
    }
}
