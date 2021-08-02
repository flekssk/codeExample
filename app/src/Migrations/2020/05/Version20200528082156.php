<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528082156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');


        $this->addSql('ALTER TABLE specialist_document ADD template_id UUID NOT NULL');
        $this->addSql('ALTER TABLE specialist_document ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE specialist_document ADD edu_date_start DATE NOT NULL');
        $this->addSql('ALTER TABLE specialist_document ADD edu_date_end DATE NOT NULL');
        $this->addSql('ALTER TABLE specialist_document ADD hours INT NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist_document.template_id IS \'ID шаблона\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.date IS \'Дата появления в CRM\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.edu_date_start IS \'Дата начала обучения\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.edu_date_end IS \'Дата окончания обучения\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.hours IS \'Затрачено часов\'');
        $this->addSql('COMMENT ON COLUMN specialist_document.specialist_id IS \'ID специалиста\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist_document DROP template_id');
        $this->addSql('ALTER TABLE specialist_document DROP date');
        $this->addSql('ALTER TABLE specialist_document DROP edu_date_start');
        $this->addSql('ALTER TABLE specialist_document DROP edu_date_end');
        $this->addSql('ALTER TABLE specialist_document DROP hours');
    }
}
