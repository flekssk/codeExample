<?php

namespace App\Infrastructure\HttpClients\SchoolProgram;

use App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramFinishedResponseAssemblerInterface;
use App\Infrastructure\HttpClients\SchoolProgram\Assembler\SchoolProgramResponseAssemblerInterface;
use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramFinishedResponseDto;
use App\Infrastructure\HttpClients\SchoolProgram\Dto\SchoolProgramResponseDto;

/**
 * Class SchoolProgramService.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram
 */
class SchoolProgramService
{
    /**
     * @var SchoolProgramClientInterface
     */
    private SchoolProgramClientInterface $schoolProgramClient;

    /**
     * @var SchoolProgramFinishedResponseAssemblerInterface
     */
    private SchoolProgramFinishedResponseAssemblerInterface $schoolProgramFinishedResponseAssembler;

    /**
     * @var SchoolProgramResponseAssemblerInterface
     */
    private SchoolProgramResponseAssemblerInterface $schoolProgramResponseAssembler;

    /**
     * SchoolProgramService constructor.
     *
     * @param SchoolProgramClientInterface $schoolProgramClient
     * @param SchoolProgramFinishedResponseAssemblerInterface $schoolProgramFinishedResponseAssembler
     * @param SchoolProgramResponseAssemblerInterface $schoolProgramResponseAssembler
     */
    public function __construct(
        SchoolProgramClientInterface $schoolProgramClient,
        SchoolProgramFinishedResponseAssemblerInterface $schoolProgramFinishedResponseAssembler,
        SchoolProgramResponseAssemblerInterface $schoolProgramResponseAssembler
    ) {
        $this->schoolProgramClient = $schoolProgramClient;
        $this->schoolProgramFinishedResponseAssembler = $schoolProgramFinishedResponseAssembler;
        $this->schoolProgramResponseAssembler = $schoolProgramResponseAssembler;
    }

    /**
     * @param int $id
     * @param array $versions
     * @param bool $onlyFinished
     *
     * @return SchoolProgramFinishedResponseDto[]
     */
    public function getUserProgramsBySpecialistIdAndVersions(int $id, array $versions, bool $onlyFinished = true): array
    {
        $schoolPrograms = [];

        $response = $this->schoolProgramClient->getUserProgramsByUserIdAndVersions($id, $versions);
        foreach ($response as $item) {
            if ($onlyFinished) {
                if ($item->programProgress != 1) {
                    continue;
                }
            }

            $schoolPrograms[$item->programId] = $this->schoolProgramFinishedResponseAssembler->assemble($item);
        }

        return $schoolPrograms;
    }

    /**
     * @param array $versions
     *
     * @return SchoolProgramResponseDto[]
     */
    public function getPrograms(array $versions): array
    {
        $schoolPrograms = [];

        $response = $this->schoolProgramClient->getProgramsByVersions($versions);
        foreach ($response as $item) {
            $schoolPrograms[$item->programId] = $this->schoolProgramResponseAssembler->assemble($item);
        }

        return $schoolPrograms;
    }
}
