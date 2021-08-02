<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200430144643 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE specialist_work_schedule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist_work_schedule (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN specialist_work_schedule.name IS \'Название\'');

        $this->insertDataIntoTable();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE specialist_work_schedule_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist_work_schedule');
    }

    private function insertDataIntoTable(): void
    {
        $data = [
            1 => 'Полный день',
            2 => 'Сменный график',
            3 => 'Гибкий график',
            4 => 'Удаленная работа',
            5 => 'Вахтовый метод',
        ];
        foreach ($data as $id => $name) {
            $this->addSql("INSERT INTO specialist_work_schedule(id, name) VALUES({$id}, '{$name}')");
        }
    }
}
