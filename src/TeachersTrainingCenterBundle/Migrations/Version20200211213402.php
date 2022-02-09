<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211213402 extends AbstractMigration
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
            'CREATE TABLE "step_progress" (id BIGSERIAL NOT NULL, user_id BIGINT NOT NULL, step_id VARCHAR(40) NOT NULL, value JSONB NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))',
        );
        $this->addSql('CREATE UNIQUE INDEX step_progress__user_id__step_id ON "step_progress" (user_id, step_id)');
        $this->addSql('COMMENT ON TABLE "step_progress" IS \'Stores data about step score and progress\'');
        $this->addSql('COMMENT ON COLUMN "step_progress".id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "step_progress".user_id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "step_progress".step_id IS \'Step uuid\'');
        $this->addSql('COMMENT ON COLUMN "step_progress".value IS \'Score, completeness(DC2Type:json_array)\'');
        $this->addSql(
            'CREATE TABLE "progress" (id BIGSERIAL NOT NULL, user_id BIGINT NOT NULL, progress_id VARCHAR(40) NOT NULL, progress_type VARCHAR(10) NOT NULL, value JSONB NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))',
        );
        $this->addSql(
            'CREATE UNIQUE INDEX progress__user_id__progress_id__progress_type ON "progress" (user_id, progress_id, progress_type)',
        );
        $this->addSql('COMMENT ON TABLE "progress" IS \'Stores data about lesson/level/etc score and progress\'');
        $this->addSql('COMMENT ON COLUMN "progress".id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "progress".user_id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "progress".progress_id IS \'Id of lesson/course to track progress\'');
        $this->addSql('COMMENT ON COLUMN "progress".progress_type IS \'Lesson/level/etc\'');
        $this->addSql('COMMENT ON COLUMN "progress".value IS \'Score, completeness(DC2Type:json_array)\'');
        $this->addSql(
            'ALTER TABLE "step_progress" ADD CONSTRAINT FK_1204F029A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
        $this->addSql(
            'ALTER TABLE "progress" ADD CONSTRAINT FK_2201F246A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.',
        );

        $this->addSql('DROP TABLE "step_progress"');
        $this->addSql('DROP TABLE "progress"');
    }
}
