<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\Doctrine\Migration;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\AbortMigration;

abstract class AbstractPostgreSQLMigration extends AbstractMigration
{
    /**
     * @throws AbortMigration
     * @throws Exception
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function preUp(Schema $schema): void
    {
        $this->checkPostgreSQLOrThrow();
    }

    /**
     * @throws AbortMigration
     * @throws Exception
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function preDown(Schema $schema): void
    {
        $this->checkPostgreSQLOrThrow();
    }

    /**
     * @throws AbortMigration
     * @throws Exception
     */
    protected function checkPostgreSQLOrThrow(): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
    }
}
