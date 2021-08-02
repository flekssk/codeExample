<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class DocumentTypeFixtures.
 *
 * @package App\DataFixtures
 */
class DocumentTypeFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    public string $tableName = 'document_type';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/document_type.php';

    public function getDependencies()
    {
        return [
            DocumentTemplateFixtures::class,
        ];
    }
}
