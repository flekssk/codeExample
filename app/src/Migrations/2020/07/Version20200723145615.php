<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723145615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('COMMENT ON COLUMN specialist.id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_order.specialist_id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_experience.specialist_id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_access.specialist_id IS \'ID специалиста\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('COMMENT ON COLUMN specialist.id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_order.specialist_id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_experience.specialist_id IS \'ID специалиста\'');
        $this->addSql('COMMENT ON COLUMN specialist_access.specialist_id IS \'ID специалиста\'');
    }
}
