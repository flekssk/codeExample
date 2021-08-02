<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist\Resolver;

use App\Application\Exception\ValidationException;
use App\Application\Specialist\Specialist\Dto\SpecialistAddDto;
use App\Domain\Entity\Specialist\Specialist;

/**
 * Interface SpecialistAddResolverInterface.
 *
 * @package App\Application\Specialist\Specialist\Resolver
 */
interface SpecialistAddResolverInterface
{
    /**
     * @param SpecialistAddDto $dto
     *
     * @return Specialist
     *
     * @throws ValidationException
     */
    public function resolve(SpecialistAddDto $dto): Specialist;
}
