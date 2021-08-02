<?php

namespace App\Application\Skill\SkillSync\Resolver;

use App\Domain\Entity\Skill\Skill;
use App\Infrastructure\HttpClients\Skills\Dto\SkillsResponseDto;

/**
 * Interface SkillSyncResolverInterface.
 *
 * @package App\Application\Skill\SkillSync\Resolver
 */
interface SkillSyncResolverInterface
{
    /**
     * @param SkillsResponseDto $responseDto
     *
     * @return Skill
     */
    public function resolve(SkillsResponseDto $responseDto): Skill;
}
