<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028095633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE skill ADD macro_skill_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD macro_skill_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD macro_type_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD macro_type_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD reestr_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD reestr_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ALTER id TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE skill DROP macro_skill_id');
        $this->addSql('ALTER TABLE skill DROP macro_skill_name');
        $this->addSql('ALTER TABLE skill DROP macro_type_id');
        $this->addSql('ALTER TABLE skill DROP macro_type_name');
        $this->addSql('ALTER TABLE skill DROP reestr_id');
        $this->addSql('ALTER TABLE skill DROP reestr_name');
        $this->addSql('ALTER TABLE skill ALTER id TYPE INT');
    }
}
