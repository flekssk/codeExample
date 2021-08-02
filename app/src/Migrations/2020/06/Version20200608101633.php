<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200608101633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE attestation_commission_member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attestation_commission_member (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, is_leader BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.first_name IS \'Имя\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.second_name IS \'Фамилия\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.middle_name IS \'Отчество\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.image_url IS \'Ссылка на аватар(DC2Type:imageUrl)\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.description IS \'Описание должности\'');
        $this->addSql('COMMENT ON COLUMN attestation_commission_member.is_leader IS \'Признак председателя комиссии\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE attestation_commission_member_id_seq CASCADE');
        $this->addSql('DROP TABLE attestation_commission_member');
    }
}
