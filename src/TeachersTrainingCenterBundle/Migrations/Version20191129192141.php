<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129192141 extends AbstractMigration
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
            'CREATE TABLE "user" (id BIGSERIAL NOT NULL, name VARCHAR(100), surname VARCHAR(100), avatar_url VARCHAR(255), locale VARCHAR(6), timezone VARCHAR(255), created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))',
        );
        $this->addSql('COMMENT ON TABLE "user" IS \'Stores data about user\'');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN "user".name IS \'User\'\'s name\'');
        $this->addSql('COMMENT ON COLUMN "user".surname IS \'User\'\'s surname\'');
        $this->addSql('COMMENT ON COLUMN "user".avatar_url IS \'Url to user\'\'s avatar\'');
        $this->addSql('COMMENT ON COLUMN "user".locale IS \'User\'\'s locale\'');
        $this->addSql('COMMENT ON COLUMN "user".timezone IS \'User\'\'s timezone\'');
        $this->addSql(
            'CREATE TABLE teacher_student (id BIGSERIAL NOT NULL, teacher_id BIGINT NOT NULL, student_id BIGINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))',
        );
        $this->addSql('CREATE INDEX IDX_7AE1227241807E1D ON teacher_student (teacher_id)');
        $this->addSql('CREATE INDEX IDX_7AE12272CB944F1A ON teacher_student (student_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7AE1227241807E1DCB944F1A ON teacher_student (teacher_id, student_id)');
        $this->addSql('COMMENT ON COLUMN teacher_student.id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN teacher_student.teacher_id IS \'(DC2Type:bigint)\'');
        $this->addSql('COMMENT ON COLUMN teacher_student.student_id IS \'(DC2Type:bigint)\'');
        $this->addSql(
            'ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE1227241807E1D FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
        $this->addSql(
            'ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE12272CB944F1A FOREIGN KEY (student_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.',
        );

        $this->addSql('ALTER TABLE teacher_student DROP CONSTRAINT FK_7AE1227241807E1D');
        $this->addSql('ALTER TABLE teacher_student DROP CONSTRAINT FK_7AE12272CB944F1A');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE teacher_student');
    }
}
