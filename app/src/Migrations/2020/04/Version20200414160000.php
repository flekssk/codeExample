<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414160000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Добавление таблицы специалистов';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE specialist (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, first_name VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, patronymic_name VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, id2position VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, employment_type VARCHAR(255) NOT NULL, schedule VARCHAR(255) NOT NULL, date_of_birth TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN specialist.id IS \'ID\'');
        $this->addSql('COMMENT ON COLUMN specialist.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN specialist.first_name IS \'Имя\'');
        $this->addSql('COMMENT ON COLUMN specialist.second_name IS \'Фамилия\'');
        $this->addSql('COMMENT ON COLUMN specialist.patronymic_name IS \'Отчество\'');
        $this->addSql('COMMENT ON COLUMN specialist.gender IS \'Пол\'');
        $this->addSql('COMMENT ON COLUMN specialist.region IS \'Регион\'');
        $this->addSql('COMMENT ON COLUMN specialist.id2position IS \'Должность из id2\'');
        $this->addSql('COMMENT ON COLUMN specialist.position IS \'Должность\'');
        $this->addSql('COMMENT ON COLUMN specialist.employment_type IS \'Вид занятости\'');
        $this->addSql('COMMENT ON COLUMN specialist.schedule IS \'Режим работы\'');
        $this->addSql('COMMENT ON COLUMN specialist.date_of_birth IS \'Дата рождени(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE specialist');
    }
}
