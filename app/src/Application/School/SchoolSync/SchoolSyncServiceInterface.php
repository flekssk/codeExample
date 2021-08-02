<?php

namespace App\Application\School\SchoolSync;

/**
 * Interface SchoolSyncServiceInterface.
 *
 * @package App\Application\School\SchoolSync
 */
interface SchoolSyncServiceInterface
{
    /**
     * Синхронизация школ.
     *
     * Возвращает количество обработанных элементов.
     *
     * @return int
     */
    public function sync(): int;
}
