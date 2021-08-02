<?php

namespace App\DataFixtures;

/**
 * Class SiteOptionFixtures.
 *
 * @package App\DataFixtures
 */
class SiteOptionFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = 'site_option';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/site_option.php';
}
