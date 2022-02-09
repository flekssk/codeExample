<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.TypeNameMatchesFileName.NoMatchBetweenTypeNameAndFileName

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use TeachersCommonBundle\Feature\Doctrine\Migration\AbstractPostgreSQLMigration;

final class Version20211125071451 extends AbstractPostgreSQLMigration
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS course_assignment_context_id_seq');
        $createAssignmentContextSql = <<< SQL
            CREATE TABLE IF NOT EXISTS course_assignment_context
            (
                id int8 NOT NULL DEFAULT nextval('course_assignment_context_id_seq'),
                course_group_id int8 NOT NULL,
                rules_id int8 NOT NULL,
                deadline_in_days INT DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        SQL;
        $this->addSql($createAssignmentContextSql);

        $this->addSql(
            "
            COMMENT ON TABLE course_assignment_context IS 'Контекст назначения курсов и групп курсов'
            "
        );
        $this->addSql(
            "
            COMMENT ON COLUMN course_assignment_context.course_group_id
            IS 'Id назначаемой группы курсов.'
            "
        );
        $this->addSql(
            "COMMENT ON COLUMN course_assignment_context.deadline_in_days
            IS 'Количество дней за которые нужно пройти курс или группу курсов'
            "
        );

        $this->addSql('CREATE SEQUENCE IF NOT EXISTS course_assignment_rules_id_seq');
        $this->addSql("CREATE TYPE course_assignment_rules_target AS ENUM ('trm', 'ttc');");
        $createAssignmentRulesSql = <<< SQL
            CREATE TABLE IF NOT EXISTS course_assignment_rules
            (
                id int8 NOT NULL DEFAULT nextval('course_assignment_rules_id_seq'),
                rules text[] NOT NULL,
                target VARCHAR NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        SQL;
        $this->addSql($createAssignmentRulesSql);

        $this->addSql("COMMENT ON TABLE course_assignment_rules IS 'Правила назначения курсов'");
        $this->addSql(
            "
            COMMENT ON COLUMN course_assignment_rules.rules
            IS 'Массив правил по которым будут назначаться курсы, например symfony expression передаваемые в trm'
            "
        );
        $this->addSql(
            "
            COMMENT ON COLUMN course_assignment_rules.target
            IS 'Имя сервиса к которому будет применяться правила. Например: ttc, trm'
            "
        );

        $this->addSql('CREATE SEQUENCE IF NOT EXISTS course_group_id_seq');
        $createCourseGroupSql = <<< SQL
            CREATE TABLE IF NOT EXISTS course_group
            (
                id int8 NOT NULL DEFAULT nextval('course_group_id_seq'),
                title VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                courses JSONB NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id)
            )
        SQL;
        $this->addSql($createCourseGroupSql);

        $this->addSql("COMMENT ON TABLE course_group IS 'Правила назначения курсов'");
        $this->addSql("COMMENT ON COLUMN course_group.title IS 'Заголовок группы курсов'");
        $this->addSql("COMMENT ON COLUMN course_group.description IS 'Описание группы курсов'");
        $this->addSql("COMMENT ON COLUMN course_group.courses IS 'Курсы в группе.'");

        $addCourseGroupConstraintSql = <<< SQL
            ALTER TABLE course_assignment_context
            ADD CONSTRAINT FK_18CA169B57E0B411
                FOREIGN KEY (course_group_id)
                REFERENCES course_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL;
        $this->addSql($addCourseGroupConstraintSql);

        $addRulesIdConstraintSql = <<< SQL
            ALTER TABLE course_assignment_context
            ADD CONSTRAINT FK_18CA169BFB699244
                FOREIGN KEY (rules_id)
                REFERENCES course_assignment_rules (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL;
        $this->addSql($addRulesIdConstraintSql);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE course_assignment_context');
        $this->addSql('DROP TABLE course_assignment_rules');
        $this->addSql('DROP TABLE course_group');
    }
}
