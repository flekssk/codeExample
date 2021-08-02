<?php

namespace App\DataFixtures;

/**
 * Class PositionFixtures.
 *
 * @package App\DataFixtures
 */
class PositionFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = 'positions';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/position.php';
}
