<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422190951 extends AbstractMigration
{

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Создание таблицы регионов';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE region (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN region.name IS \'Название\'');
        $this->insertDataIntoTable();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE IF EXISTS region');
    }

    private function insertDataIntoTable(): void
    {
        $filename = __DIR__ . '/data/regions.csv';
        $file = fopen($filename, 'rb');
        while (($line = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($line[0], $line[1])) {
                continue;
            }
            $id = isset($line[0]) ? $line[0] : null;
            $name = isset($line[1]) ? $line[1] : null;
            $this->addSql("INSERT INTO region(id, name) VALUES({$id}, '{$name}')");
        }
        fclose($file);
    }
}
