<?php

declare(strict_types=1);

namespace App\Application\Id2\Assembler;

use App\Domain\Entity\Event\CustomValue;
use App\Application\Id2\Dto\CustomValueDto;

/**
 * Class CustomValueAssembler.
 *
 * @package \App\Application\CustomValue\Assembler
 */
class CustomValueAssembler
{

    /**
     * @param CustomValue $customValue
     * @return CustomValueDto
     */
    public function assemble(CustomValue $customValue): CustomValueDto
    {
        $dto = new CustomValueDto();
        $dto->name = $customValue->getName();
        $dto->key = $customValue->getKey();
        $dto->value = $customValue->getValue();

        return $dto;
    }
}
