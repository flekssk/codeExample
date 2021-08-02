<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619101609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE document_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE document_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, template_name VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, image_preview VARCHAR(255) NOT NULL, image_background VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, document_template VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B6ADBBABE313A74 ON document_type (document_template)');
        $this->addSql('COMMENT ON COLUMN document_type.name IS \'Название типа\'');
        $this->addSql('COMMENT ON COLUMN document_type.template_name IS \'Название шаблона верстки\'');
        $this->addSql('COMMENT ON COLUMN document_type.active IS \'Флаг активности\'');
        $this->addSql('COMMENT ON COLUMN document_type.image_preview IS \'URL изображения для превью(DC2Type:imageUrl)\'');
        $this->addSql('COMMENT ON COLUMN document_type.image_background IS \'URL изображения для фона(DC2Type:imageUrl)\'');
        $this->addSql('COMMENT ON COLUMN document_type.created_at IS \'Дата создания(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN document_type.updated_at IS \'Дата изменения(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE document_type ADD CONSTRAINT FK_2B6ADBBABE313A74 FOREIGN KEY (document_template) REFERENCES document_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE document_type_id_seq CASCADE');
        $this->addSql('DROP TABLE document_type');
    }
}
