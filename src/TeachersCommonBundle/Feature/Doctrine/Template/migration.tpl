<?php

declare(strict_types=1);

namespace <namespace>;

use Doctrine\DBAL\Schema\Schema;
use TeachersCommonBundle\Feature\Doctrine\Migration\AbstractPostgreSQLMigration;

final class Version<version> extends AbstractPostgreSQLMigration
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function up(Schema $schema): void
    {
        <up>
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function down(Schema $schema): void
    {
        <down>
    }
}
