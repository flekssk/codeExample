<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200416150817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE specialist ALTER gender TYPE INT USING (gender::integer)');
        $this->addSql('ALTER TABLE specialist ALTER gender DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER region TYPE INT USING (region::integer)');
        $this->addSql('ALTER TABLE specialist ALTER region DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER id2position TYPE INT USING (id2position::integer)');
        $this->addSql('ALTER TABLE specialist ALTER id2position DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist RENAME COLUMN patronymic_name TO middle_name');
        $this->addSql('COMMENT ON COLUMN specialist.avatar IS \'Ссылка на аватар(DC2Type:imageUrl)\'');
        $this->addSql('COMMENT ON COLUMN specialist.gender IS \'Пол(DC2Type:gender)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist DROP avatar');
        $this->addSql('ALTER TABLE specialist ALTER gender TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER gender DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER region TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER region DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER id2position TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER id2position DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist RENAME COLUMN middle_name TO patronymic_name');
        $this->addSql('COMMENT ON COLUMN specialist.gender IS \'Пол\'');
    }
}
