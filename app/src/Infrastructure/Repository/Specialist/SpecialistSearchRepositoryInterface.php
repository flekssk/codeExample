<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;

/**
 * Interface SpecialistSearchRepositoryInterface.
 */
interface SpecialistSearchRepositoryInterface
{
    /**
     * Возвращает список специалистов в соответсвие с критериями поиска и пагинацией.
     *
     * @param SpecialistFindDto $findDto
     *
     * @param string            $orderBy
     * @param int               $limit
     * @param int               $offset
     * @param string            $orderDirection
     *
     * @return Specialist[]
     */
    public function findBy(
        SpecialistFindDto $findDto,
        string $orderBy = null,
        int $limit = 20,
        int $offset = 1,
        string $orderDirection = 'desc'
    ): array;

    /**
     * Возвращает количесво записей в соответсвие с критериями поиска.
     *
     * @param SpecialistFindDto $findDto
     *
     * @return int
     */
    public function findResultsTotalCount(SpecialistFindDto $findDto): int;
}
