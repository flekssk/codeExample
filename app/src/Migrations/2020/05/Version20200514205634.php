<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514205634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE "order" (id INT NOT NULL DEFAULT nextval(\'order_id_seq\'), name VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, pdf_url VARCHAR(255) NOT NULL, data TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))'
        );
        /** @noinspection MissedParamInspection */
        $this->addSql('COMMENT ON COLUMN "order".data IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'CREATE TABLE specialist_order (specialist_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(specialist_id, order_id))'
        );
        $this->addSql('CREATE INDEX IDX_4C9FB14A7B100C1A ON specialist_order (specialist_id)');
        $this->addSql('CREATE INDEX IDX_4C9FB14A8D9F6D38 ON specialist_order (order_id)');
        $this->addSql("COMMENT ON COLUMN specialist_order.specialist_id IS 'ID специалиста'");
        $this->addSql(
            'ALTER TABLE specialist_order ADD CONSTRAINT FK_4C9FB14A7B100C1A FOREIGN KEY (specialist_id) REFERENCES specialist (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE specialist_order ADD CONSTRAINT FK_4C9FB14A8D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist_order DROP CONSTRAINT FK_4C9FB14A8D9F6D38');
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE specialist_order');
    }
}
