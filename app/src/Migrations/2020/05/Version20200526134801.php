<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526134801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "order" DROP name');
        $this->addSql('ALTER TABLE "order" ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" ALTER pdf_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER pdf_url DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "order".type IS \'(DC2Type:orderType)\'');
        $this->addSql('COMMENT ON COLUMN "order".number IS \'(DC2Type:orderNumber)\'');
        $this->addSql('COMMENT ON COLUMN "order".pdf_url IS \'(DC2Type:pdfUrl)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER number DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" ALTER pdf_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER pdf_url DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN "order".number IS NULL');
        $this->addSql('COMMENT ON COLUMN "order".pdf_url IS NULL');
    }
}
