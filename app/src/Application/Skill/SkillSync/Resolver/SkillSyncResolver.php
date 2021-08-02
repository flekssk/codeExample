<?php

namespace App\Application\Skill\SkillSync\Resolver;

use App\Domain\Entity\Skill\Skill;
use App\Infrastructure\HttpClients\Skills\Dto\SkillsResponseDto;

/**
 * Class SkillSyncResolver.
 *
 * @package App\Application\Skill\Resolver
 */
class SkillSyncResolver implements SkillSyncResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(SkillsResponseDto $responseDto): Skill
    {
        return new Skill(
            $responseDto->id,
            $responseDto->name,
            $responseDto->macroSkillId,
            $responseDto->macroSkillName,
            $responseDto->macroTypeId,
            $responseDto->macroTypeName,
            $responseDto->reestrId,
            $responseDto->reestrName,
        );
    }
}
