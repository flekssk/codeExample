<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler;

use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;

/**
 * Class SpecialistFindAssembler.
 *
 * @package App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Assembler
 */
class SpecialistSearchAssembler implements SpecialistSearchAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(
        string $searchString,
        string $company,
        string $id2Position,
        string $document,
        string $region,
        ?int $status
    ): SpecialistFindDto {
        $dto = new SpecialistFindDto();

        $dto->searchString = $searchString;
        $dto->company = $company;
        $dto->id2Position = $id2Position;
        $dto->document = $document;
        $dto->region = $region;
        $dto->status = $status;

        return $dto;
    }
}
