<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200515151928 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE specialist_document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist_document (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, specialist_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN specialist_document.name IS \'Название\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.description IS \'Описание\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.number IS \'Номер документа\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.specialist_id IS \'ID специалиста\'');
        $this->addSql('ALTER TABLE specialist_document ALTER id SET DEFAULT nextval(\'public.specialist_document_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE specialist_document_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist_document');
    }
}
