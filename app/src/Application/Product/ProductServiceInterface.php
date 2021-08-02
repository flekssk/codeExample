<?php

namespace App\Application\Product;

/**
 * Interface ProductServiceInterface.
 */
interface ProductServiceInterface
{
    /**
     * Обновление продуктов.
     *
     * @return int
     */
    public function update(): int;
}
