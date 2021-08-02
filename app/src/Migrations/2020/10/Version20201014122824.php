<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTimeImmutable;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014122824 extends AbstractMigration
{
    private array $options = [
        [
            'name' => 'keySkillsDescriptionText',
            'description' => 'Ключевые навыки. Для выделения жирным используйте символ "*" (пример: *жирный текст*), для выделения курсивом "_" (пример: _текст курсивом_)',
            'value' => '',
        ],
        [
            'name' => 'professionalGrowSkillsDescriptionText',
            'description' => 'Навыки профессионального роста. Для выделения жирным используйте символ "*" (пример: *жирный текст*), для выделения курсивом "_" (пример: _текст курсивом_)',
            'value' => '',
        ],
    ];

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        foreach ($this->options as $option) {
            $dateTime = new DateTimeImmutable();
            $this->addSql("INSERT INTO site_option (name, value, description, created_at) VALUES ('{$option['name']}', '{$option['value']}', '{$option['description']}', '{$dateTime->format('Y-m-d')}')");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        foreach ($this->options as $option) {
            $this->addSql("DELETE FROM site_option WHERE name = '{$option['name']}'");
        }
    }
}
