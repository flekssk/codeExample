<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428174946 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE positions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE positions ADD guid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE positions DROP type_id');
        $this->addSql('ALTER TABLE positions DROP type_name');
        $this->addSql('ALTER TABLE positions ALTER id TYPE INT USING (id::integer)');
        $this->addSql('ALTER TABLE positions ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN positions.guid IS \'GUID\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE positions_id_seq CASCADE');
        $this->addSql('ALTER TABLE positions ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE positions ADD type_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE positions DROP guid');
        $this->addSql('ALTER TABLE positions ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE positions ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN positions.type_id IS \'ID типа\'');
        $this->addSql('COMMENT ON COLUMN positions.type_name IS \'Тип\'');
    }
}
