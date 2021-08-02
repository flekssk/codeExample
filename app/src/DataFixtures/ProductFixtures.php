<?php

namespace App\DataFixtures;

/**
 * Class ProductFixtures.
 *
 * @package App\DataFixtures
 */
class ProductFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = 'product';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/product.php';
}
