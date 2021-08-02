<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602165449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE document_template (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, document_type VARCHAR(255) DEFAULT NULL, disciplines_name VARCHAR(255) NOT NULL, year TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN document_template.name IS \'Название\'');
        $this->addSql('COMMENT ON COLUMN document_template.document_type IS \'Тип документа\'');
        $this->addSql('COMMENT ON COLUMN document_template.disciplines_name IS \'Название дисциплины\'');
        $this->addSql('COMMENT ON COLUMN document_template.year IS \'Год шаблона(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE document_template');
    }
}
