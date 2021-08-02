<?php

namespace App\Infrastructure\HttpClients\School\Assembler;

use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;

/**
 * Class SchoolResponseAssembler.
 *
 * @package App\Infrastructure\HttpClients\School\Assembler
 */
class SchoolResponseAssembler implements SchoolResponseAssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function assemble(int $id, string $name): SchoolResponseDto
    {
        $dto = new SchoolResponseDto();

        $dto->id = $id;
        // Заменить название у школы по умолчанию на 'По умолчанию'.
        $dto->name = $name == 'default' ? 'По умолчанию' : $name;

        return $dto;
    }
}
