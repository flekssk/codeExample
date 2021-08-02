<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514105150 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE specialist_occupation_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist_occupation_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN specialist_occupation_type.name IS \'Название\'');
        $this->addSql('ALTER TABLE specialist_occupation_type ALTER id SET DEFAULT nextval(\'specialist_occupation_type_id_seq\')');

        $this->insertDataIntoTable();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE specialist_occupation_type_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist_occupation_type');
    }

    private function insertDataIntoTable(): void
    {
        $data = [
            1 => 'Полная занятость',
            2 => 'Частичная занятость',
            3 => 'Проектная работа',
            4 => 'Волонтерство',
            5 => 'Стажировка',
        ];
        foreach ($data as $id => $name) {
            $this->addSql("INSERT INTO specialist_occupation_type(name) VALUES('{$name}')");
        }
    }
}
