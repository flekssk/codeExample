<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class SpecialistOrder
 *
 * @package App\DataFixtures
 */
class SpecialistOrder extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    public string $tableName = 'specialist_order';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/specialist_order.php';

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            OrderFixtures::class,
            SpecialistsFixtures::class,
        ];
    }
}
