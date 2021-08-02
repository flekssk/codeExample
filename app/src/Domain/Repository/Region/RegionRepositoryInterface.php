<?php

namespace App\Domain\Repository\Region;

use App\Domain\Entity\Region\Region;

/**
 * Interface RegionRepositoryInterface.
 *
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface RegionRepositoryInterface
{

    /**
     * Сохранение сущности.
     *
     * @param Region $region
     *
     * @return void
     */
    public function save(Region $region): void;

    /**
     * Поиск по части названия региона.
     *
     * @param string $name
     * @param int    $count
     *
     * @return array
     */
    public function findByName(string $name, int $count): array;

    /**
     * @param int $id
     *
     * @return Region|null
     */
    public function findById(int $id): ?Region;
}
