<?php

namespace App\Infrastructure\HttpClients\Skills;

/**
 * Interface SkillsClientInterface.
 *
 * @package App\Infrastructure\HttpClients\Skills
 */
interface SkillsClientInterface
{
    /**
     * @param string $guid
     *
     * @return mixed
     */
    public function getByRegistryId(string $guid);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getByUserId(int $id);
}
