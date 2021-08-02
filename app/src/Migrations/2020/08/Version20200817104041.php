<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817104041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER gender TYPE INT');
        $this->addSql('ALTER TABLE specialist ALTER gender DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER status TYPE INT');
        $this->addSql('ALTER TABLE specialist ALTER status DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN specialist.gender IS \'Пол\'');
        $this->addSql('COMMENT ON COLUMN specialist.status IS \'Статус специалиста\'');
        $this->addSql('ALTER TABLE "order" ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER type DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "order".number IS NULL');
        $this->addSql('COMMENT ON COLUMN "order".type IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER gender TYPE INT');
        $this->addSql('ALTER TABLE specialist ALTER gender DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER status TYPE INT');
        $this->addSql('ALTER TABLE specialist ALTER status SET DEFAULT 0');
        $this->addSql('COMMENT ON COLUMN specialist.gender IS \'Пол(DC2Type:gender)\'');
        $this->addSql('COMMENT ON COLUMN specialist.status IS \'Статус специалиста(DC2Type:specialistStatus)\'');
        $this->addSql('ALTER TABLE "order" ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER type DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "order".number IS \'(DC2Type:orderNumber)\'');
        $this->addSql('COMMENT ON COLUMN "order".type IS \'(DC2Type:orderType)\'');
    }
}
