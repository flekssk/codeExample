<?php

namespace App\DataFixtures;

/**
 * Class OrderFixtures.
 *
 * @package App\DataFixtures
 */
class OrderFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = '"order"';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/order.php';
}
