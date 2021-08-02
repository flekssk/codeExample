<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603105359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE specialist_document DROP description');
        $this->addSql('ALTER TABLE specialist_document ADD disciplines_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN specialist_document.disciplines_name IS \'Название дисциплины\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist_document DROP disciplines_name');
        $this->addSql('ALTER TABLE specialist_document ADD description VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN specialist_document.description IS \'Описание\'');
    }
}
