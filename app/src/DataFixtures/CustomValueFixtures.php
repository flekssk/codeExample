<?php

namespace App\DataFixtures;

/**
 * Class CustomValueFixtures
 * @package App\DataFixtures
 */
class CustomValueFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = 'custom_value';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/custom_value.php';
}
