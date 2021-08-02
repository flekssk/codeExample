<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Resolver;

use App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Interface SpecialistUpdateResolverInterface.
 *
 * @package App\Application\Specialist\Specialist\Resolver
 */
interface SpecialistUpdateResolverInterface
{
    /**
     * @param SpecialistUpdateDto $dto
     *
     * @return Specialist
     */
    public function resolve(SpecialistUpdateDto $dto): Specialist;
}
