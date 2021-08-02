<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113141610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE skill_improve_link_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE skill_improve_link (id SERIAL NOT NULL, skill_id VARCHAR(255) NOT NULL, school_id INT NOT NULL DEFAULT 0, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN skill_improve_link.skill_id IS \'ID навыка\'');
        $this->addSql('COMMENT ON COLUMN skill_improve_link.school_id IS \'ID школы\'');
        $this->addSql('COMMENT ON COLUMN skill_improve_link.link IS \'Ссылка\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE skill_improve_link_id_seq CASCADE');
        $this->addSql('DROP TABLE skill_improve_link');
    }
}
