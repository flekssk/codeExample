<?php

namespace App\Infrastructure\HttpClients\SchoolProgram;

/**
 * Interface SchoolProgramClientInterface.
 *
 * @package App\Infrastructure\HttpClients\SchoolProgram
 */
interface SchoolProgramClientInterface
{
    /**
     * @param int $id
     * @param array $versions
     *
     * @return array
     */
    public function getUserProgramsByUserIdAndVersions(int $id, array $versions): array;

    /**
     * @param array $versions
     *
     * @return array
     */
    public function getProgramsByVersions(array $versions): array;
}
