<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200730122407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE entity_revision_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entity_revision (id INT NOT NULL, entity_id INT NOT NULL, entity_type VARCHAR(255) NOT NULL, content TEXT NOT NULL, user_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN entity_revision.entity_id IS \'ID сущности\'');
        $this->addSql('COMMENT ON COLUMN entity_revision.entity_type IS \'Тип сущности\'');
        $this->addSql('COMMENT ON COLUMN entity_revision.content IS \'Контент\'');
        $this->addSql('COMMENT ON COLUMN entity_revision.user_id IS \'ID пользователя\'');
        $this->addSql('COMMENT ON COLUMN entity_revision.created_at IS \'Дата создания(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE entity_revision_id_seq CASCADE');
        $this->addSql('DROP TABLE entity_revision');
    }
}
