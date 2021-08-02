<?php

namespace App\Domain\Repository\Product;

use App\Domain\Entity\Product\Product;

/**
 * Interface PositionRepositoryInterface.
 */
interface ProductRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function findById(int $id): ?Product;

    /**
     * @return int[]
     */
    public function findAllIds(): array;

    /**
     * @param Product $product
     *
     * @return void
     */
    public function save(Product $product): void;

    /**
     * @param Product $product
     *
     * @return void
     */
    public function delete(Product $product): void;

    /**
     * @return void
     */
    public function deleteAll(): void;

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
