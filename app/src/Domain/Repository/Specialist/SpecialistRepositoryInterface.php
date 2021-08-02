<?php

declare(strict_types=1);

namespace App\Domain\Repository\Specialist;

use App\Domain\Entity\Specialist\Specialist;
use App\Domain\Repository\NotFoundException;
use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface SpecialistRepositoryInterface.
 *
 * @method Specialist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialist[]    findAll()
 * @method Specialist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\Specialist
 */
interface SpecialistRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Specialist
     * @throws NotFoundException
     */
    public function get(int $id): Specialist;

    /**
     * @param Specialist $specialist
     */
    public function save(Specialist $specialist): void;

    /**
     * Get total count of specialist entities
     *
     * @return int
     */
    public function totalCount(): int;

    /**
     * @param      $alias
     * @param null $indexBy
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null);

    /**
     * @param int $id
     *
     * @return bool
     */
    public function has(int $id): bool;

    /**
     * @param DateTimeInterface $from
     * @param DateTimeInterface|null $to
     *
     * @return array
     */
    public function findSpecialistsIDsByCreationDateRange(DateTimeInterface $from, DateTimeInterface $to = null): array;

    /**
     * @return Specialist[]
     */
    public function findAllSpecialist(): array;

    /**
     * @param string $criteria
     * @param int|null $limit
     *
     * @return int[]
     */
    public function findAllSpecialistsIDs(string $criteria = '', ?int $limit = null): array;
}
