<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720152713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE attestation_commission_member ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url DROP DEFAULT');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.updated_at IS \'Дата последнего изменения(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.image_url IS \'Ссылка на аватар\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE attestation_commission_member DROP updated_at');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url DROP DEFAULT');
        $this->addSql('ALTER TABLE attestation_commission_member ALTER image_url SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.image_url IS \'Ссылка на аватар(DC2Type:imageUrl)\'');
    }
}
