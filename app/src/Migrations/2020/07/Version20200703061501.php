<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703061501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SEQUENCE id2_events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE id2_events (id INT NOT NULL DEFAULT nextval(\'public.id2_events_id_seq\'), name VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, category1 VARCHAR(255) DEFAULT NULL, category2 VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN id2_events.name IS \'Имя события\'');
        $this->addSql('COMMENT ON COLUMN id2_events.action IS \'Название типа события\'');
        $this->addSql('COMMENT ON COLUMN id2_events.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql("INSERT INTO id2_events (name, action) VALUES ('search', 'fscan')");
        $this->addSql("INSERT INTO id2_events (name, action) VALUES ('registration', 'Registrycheckin')");
        $this->addSql("INSERT INTO id2_events (name, action) VALUES ('profileView', 'Viewprofile')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE id2_events_id_seq CASCADE');
        $this->addSql('DROP TABLE id2_events');
    }
}
