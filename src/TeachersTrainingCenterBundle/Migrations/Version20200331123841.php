<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331123841 extends AbstractMigration
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
            'Migration can only be executed safely on \'postgresql\'.',
        );

        $this->addSql(
            'CREATE TABLE "lesson_node" (id BIGSERIAL NOT NULL, student_id BIGINT NOT NULL, lesson_id BIGINT NOT NULL, node_id BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))',
        );
        $this->addSql('CREATE INDEX IDX_BC0E2E21CB944F1A ON "lesson_node" (student_id)');
        $this->addSql('CREATE INDEX student_lesson_idx ON "lesson_node" (student_id, lesson_id)');
        $this->addSql('COMMENT ON TABLE "lesson_node" IS \'Data about user lessons\'');
        $this->addSql('COMMENT ON COLUMN "lesson_node".id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "lesson_node".student_id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "lesson_node".lesson_id IS \'Structure lesson id(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "lesson_node".node_id IS \'Rooms node id(DC2Type:bigint)\'');
        $this->addSql(
            'ALTER TABLE "lesson_node" ADD CONSTRAINT FK_BC0E2E21CB944F1A FOREIGN KEY (student_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.',
        );

        $this->addSql('DROP TABLE "lesson_node"');
    }
}
