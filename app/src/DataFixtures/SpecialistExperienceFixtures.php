<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class SpecialistsExperienceFixtures.
 *
 * @package App\DataFixtures
 */
class SpecialistExperienceFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    public string $tableName = 'specialist_experience';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/specialist_experience.php';

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            SpecialistsFixtures::class,
        ];
    }
}
