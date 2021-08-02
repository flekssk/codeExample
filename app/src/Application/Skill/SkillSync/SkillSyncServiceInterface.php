<?php

namespace App\Application\Skill\SkillSync;

/**
 * Interface SkillSyncServiceInterface.
 *
 * @package App\Application\Skill\SkillSync
 */
interface SkillSyncServiceInterface
{
    /**
     * Синхронизация навыков.
     *
     * @return int
     */
    public function sync(): int;
}
