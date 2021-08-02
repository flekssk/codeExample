<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028112647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE skill DROP CONSTRAINT skill_pkey');
        $this->addSql('ALTER TABLE skill ADD COLUMN internal_id SERIAL');
        $this->addSql('ALTER TABLE skill ADD PRIMARY KEY (internal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE skill_internal_id_seq CASCADE');
        $this->addSql('DROP INDEX skill_pkey');
        $this->addSql('ALTER TABLE skill DROP CONSTRAINT skill_pkey');
        $this->addSql('ALTER TABLE skill DROP internal_id');
        $this->addSql('ALTER TABLE skill ADD PRIMARY KEY (id)');
    }
}
