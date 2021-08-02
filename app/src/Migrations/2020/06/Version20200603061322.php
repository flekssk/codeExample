<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603061322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE specialist_access_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist_access (id INT NOT NULL, specialist_id INT NOT NULL, product_id INT NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql("COMMENT ON COLUMN specialist_access.specialist_id IS 'ID специалиста'");
        $this->addSql("COMMENT ON COLUMN specialist_access.product_id IS 'ID продукта'");
        /** @noinspection MissedParamInspection */
        $this->addSql("COMMENT ON COLUMN specialist_access.date_start IS 'Дата начала доступа(DC2Type:datetime_immutable)'");
        /** @noinspection MissedParamInspection */
        $this->addSql("COMMENT ON COLUMN specialist_access.date_end IS 'Дата окончания доступа(DC2Type:datetime_immutable)'");
        $this->addSql('ALTER TABLE specialist ADD date_check_access TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE specialist_access_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist_access');
        $this->addSql('ALTER TABLE specialist DROP date_check_access');
    }
}
