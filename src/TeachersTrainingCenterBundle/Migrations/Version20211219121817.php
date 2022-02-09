<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.TypeNameMatchesFileName.NoMatchBetweenTypeNameAndFileName

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use TeachersCommonBundle\Feature\Doctrine\Migration\AbstractPostgreSQLMigration;

final class Version20211219121817 extends AbstractPostgreSQLMigration
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_course ADD COLUMN IF NOT EXISTS deadline TIMESTAMP DEFAULT NULL;');
        $this->addSql('ALTER TABLE user_course ADD COLUMN IF NOT EXISTS assignment_context_id int8 DEFAULT NULL;');
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_course DROP COLUMN deadline;');
        $this->addSql('ALTER TABLE user_course DROP COLUMN context_id;');
    }
}
