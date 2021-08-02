<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513092854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE specialist_experience_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist_experience (id INT NOT NULL, specialist_id INT NOT NULL, company VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql("COMMENT ON COLUMN specialist_experience.specialist_id IS 'ID специалиста'");
        $this->addSql("COMMENT ON COLUMN specialist_experience.company IS 'Название компании'");
        /** @noinspection MissedParamInspection */
        $this->addSql("COMMENT ON COLUMN specialist_experience.start_date IS 'Дата начала работы в компании(DC2Type:datetime_immutable)'");
        /** @noinspection MissedParamInspection */
        $this->addSql("COMMENT ON COLUMN specialist_experience.end_date IS 'Дата окончания работы в компании(DC2Type:datetime_immutable)'");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE specialist_experience_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist_experience');
    }
}
