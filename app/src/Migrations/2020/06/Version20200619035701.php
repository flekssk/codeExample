<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619035701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist_document ADD type_document VARCHAR(255) DEFAULT NULL');
        $this->addSql("ALTER TABLE specialist_document ADD crm_id UUID NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000'");
        $this->addSql("COMMENT ON COLUMN specialist_document.crm_id IS 'GUID документа в CRM'");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist_document DROP type_document');
        $this->addSql('ALTER TABLE specialist_document DROP crm_id');
    }
}
