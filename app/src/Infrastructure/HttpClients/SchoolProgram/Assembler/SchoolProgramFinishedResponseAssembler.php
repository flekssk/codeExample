<?php

namespace App\Infrastructure\HttpClients\SchoolProgram\Assembler;

use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramFinishedResponseDto;
use DateTimeImmutable;
use Exception;

/**
 * Class SchoolProgramFinishedResponseAssembler.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram\Assembler
 */
class SchoolProgramFinishedResponseAssembler implements SchoolProgramFinishedResponseAssemblerInterface
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function assemble(object $item): SchoolProgramFinishedResponseDto
    {
        $dto = new SchoolProgramFinishedResponseDto();

        $dto->programId = $item->programId;
        $dto->programTitle = $item->programTitle;
        $dto->programPost = $item->programPost;

        $programDateStart = $item->programDateStart;
        if ($programDateStart) {
            $programDateStartObject = new DateTimeImmutable($programDateStart);

            $dto->programDateStart = $programDateStartObject->format('Y-m-d');
        }

        $programDateEnd = $item->programDateEnd;
        if ($programDateEnd) {
            $programDateEndObject = new DateTimeImmutable($programDateEnd);

            $dto->programDateEnd = $programDateEndObject->format('Y-m-d');
        }

        $dto->programProgress = $item->programProgress;

        return $dto;
    }
}
