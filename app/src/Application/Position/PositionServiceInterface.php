<?php

namespace App\Application\Position;

/**
 * Interface PositionServiceInterface.
 */
interface PositionServiceInterface
{

    /**
     * Обновление справочника должностей.
     *
     * @return int
     */
    public function update(): int;

    /**
     * Поиск по названию.
     *
     * @param string $positionName
     * @param int $count
     * @return array
     */
    public function search(string $positionName, int $count): array;
}
