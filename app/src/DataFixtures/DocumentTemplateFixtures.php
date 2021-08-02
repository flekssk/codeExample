<?php

namespace App\DataFixtures;

/**
 * Class DocumentTemplateFixtures.
 *
 * @package App\DataFixtures
 */
class DocumentTemplateFixtures extends AbstractFixture
{
    /**
     * @var string
     */
    public string $tableName = 'document_template';

    /**
     * @var string
     */
    public string $dataFile = 'tests/fixtures/document_template.php';
}
