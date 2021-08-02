<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!s
 */
final class Version20200506080915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER first_name DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER second_name DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER middle_name DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER gender DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER region DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER id2position DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER date_of_birth DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist.date_of_birth IS \'Дата рождения(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist ALTER first_name SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER second_name SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER middle_name SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER gender SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER region SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER id2position SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER date_of_birth SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist.date_of_birth IS \'Дата рождени(DC2Type:datetime_immutable)\'');
    }
}
