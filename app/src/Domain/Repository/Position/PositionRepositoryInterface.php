<?php

namespace App\Domain\Repository\Position;

use App\Domain\Entity\Position\Position;

/**
 * Interface PositionRepositoryInterface.
 */
interface PositionRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Position|null
     */
    public function findById(int $id): ?Position;

    /**
     * @param Position $position
     * @return Position
     */
    public function replace(Position $position): Position;

    /**
     * @param Position $position
     * @return void
     */
    public function save(Position $position): void;

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

    /**
     * @return void
     */
    public function truncate(): void;

    /**
     * Поиск по части названия должности.
     *
     * @param string $name
     * @param int $count
     * @return array
     */
    public function searchByName(string $name, int $count): array;
}
