<?php

namespace App\Application\School\SchoolSync\Resolver;

use App\Domain\Entity\School\School;
use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;

/**
 * Class SchoolSyncResolver.
 *
 * @package App\Application\School\SchoolSync\Resolver
 */
class SchoolSyncResolver implements SchoolSyncResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(SchoolResponseDto $responseDto): School
    {
        return new School(
            $responseDto->id,
            $responseDto->name,
        );
    }
}
