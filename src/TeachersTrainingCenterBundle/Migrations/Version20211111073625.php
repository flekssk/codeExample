<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.TypeNameMatchesFileName.NoMatchBetweenTypeNameAndFileName

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use TeachersCommonBundle\Feature\Doctrine\Migration\AbstractPostgreSQLMigration;

final class Version20211111073625 extends AbstractPostgreSQLMigration
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS doctrine_migration_versions');
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function down(Schema $schema): void
    {
        $createTableQuery = <<<SQL
            CREATE TABLE IF NOT EXISTS doctrine_migration_versions
            (
                version VARCHAR (191) NOT NULL CONTAINS doctrine_migration_versions_pkey PRIMARY KEY,
                executed_at    TIMESTAMP (0) DEFAULT NULL::timestamp WITHOUT TIME ZONE,
                execution_time INTEGER
            );
        SQL;


        $this->addSql($createTableQuery);
    }
}
