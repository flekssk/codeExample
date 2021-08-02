<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714142428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER "position" DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER "schedule" DROP NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER "employment_type" DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist.position IS NULL');
        $this->addSql('COMMENT ON COLUMN specialist.employment_type IS NULL');
        $this->addSql('COMMENT ON COLUMN specialist.schedule IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER position SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER schedule SET NOT NULL');
        $this->addSql('ALTER TABLE specialist ALTER employment_type SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN specialist."position" IS \'Должность\'');
        $this->addSql('COMMENT ON COLUMN specialist.employment_type IS \'Вид занятости\'');
        $this->addSql('COMMENT ON COLUMN specialist.schedule IS \'Режим работы\'');
    }
}
