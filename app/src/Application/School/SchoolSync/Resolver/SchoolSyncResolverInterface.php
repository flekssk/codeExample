<?php

namespace App\Application\School\SchoolSync\Resolver;

use App\Domain\Entity\School\School;
use App\Infrastructure\HttpClients\School\Dto\SchoolResponseDto;

/**
 * Interface SchoolSyncResolverInterface.
 *
 * @package App\Application\School\SchoolSync\Resolver
 */
interface SchoolSyncResolverInterface
{
    /**
     * @param SchoolResponseDto $responseDto
     *
     * @return School
     */
    public function resolve(SchoolResponseDto $responseDto): School;
}
