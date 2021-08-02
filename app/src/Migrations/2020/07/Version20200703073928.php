<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703073928 extends AbstractMigration
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

        $this->addSql('CREATE SEQUENCE custom_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE custom_value (id INT NOT NULL DEFAULT nextval(\'public.custom_value_id_seq\'), name VARCHAR(255) NOT NULL, key VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN custom_value.name IS \'Имя события\'');
        $this->addSql('COMMENT ON COLUMN custom_value.key IS \'Имя свойства\'');
        $this->addSql('COMMENT ON COLUMN custom_value.value IS \'Значение свойства\'');

        $this->addSql("INSERT INTO custom_value (name) VALUES ('registration')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE custom_value_id_seq CASCADE');
        $this->addSql('DROP TABLE custom_value');
    }
}
