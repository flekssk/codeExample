<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720143759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE document_type ALTER image_preview TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE document_type ALTER image_preview SET DEFAULT NULL');
        $this->addSql('ALTER TABLE document_type ALTER image_background TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE document_type ALTER image_background SET DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN document_type.image_preview IS \'URL изображения для превью\'');
        $this->addSql('COMMENT ON COLUMN document_type.image_background IS \'URL изображения для фона\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE document_type ALTER image_preview TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE document_type ALTER image_preview DROP DEFAULT');
        $this->addSql('ALTER TABLE document_type ALTER image_background TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE document_type ALTER image_background DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN document_type.image_preview IS \'URL изображения для превью(DC2Type:imageUrl)\'');
        $this->addSql('COMMENT ON COLUMN document_type.image_background IS \'URL изображения для фона(DC2Type:imageUrl)\'');
    }
}
