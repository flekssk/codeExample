<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602102847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist_document ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist_document ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist_document ALTER number SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist_document.number IS \'Номер документа(DC2Type:documentNumber)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist_document ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist_document ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist_document ALTER number DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist_document.number IS \'Номер документа\'');
    }
}
