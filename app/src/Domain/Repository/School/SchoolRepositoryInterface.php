<?php

namespace App\Domain\Repository\School;

use App\Domain\Entity\School\School;

/**
 * Interface SchoolRepositoryInterface.
 *
 * @method School[]    findAll()
 * @method School|null find($id, $lockMode = null, $lockVersion = null)
 * @method School|null findOneBy(array $criteria, array $orderBy = null)
 * @method School[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Domain\Repository\School
 */
interface SchoolRepositoryInterface
{
    /**
     * @param School $school
     */
    public function save(School $school): void;

    /**
     * @param School $school
     *
     * @return void
     */
    public function delete(School $school): void;

    /**
     * @return void
     */
    public function deleteAll(): void;

    /**
     * @param string $id
     *
     * @return School|null
     */
    public function findById(string $id): ?School;

    /**
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * @return void
     */
    public function commit(): void;

    /**
     * @return void
     */
    public function rollback(): void;
}
