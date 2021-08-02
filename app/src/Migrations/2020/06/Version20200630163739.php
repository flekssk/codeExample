<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTimeImmutable;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200630163739 extends AbstractMigration
{
    private array $options = [
        [
            'name' => 'contactEmail',
            'description' => 'Email для связи'
        ],
        [
            'name' => 'versions',
            'description' => 'Версии (при синхронизации с CRM)'
        ],
        [
            'name' => 'counterGoogle',
            'description' => 'Счетчик Google Analytics'
        ],
        [
            'name' => 'counterYandex',
            'description' => 'Счетчик Yandex.Metrika'
        ],
        [
            'name' => 'verificationGoogle',
            'description' => 'Код подтверждения Google'
        ],
        [
            'name' => 'verificationYandex',
            'description' => 'Код подтверждения Yandex'
        ],
    ];

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        foreach ($this->options as $option) {
            $dateTime = new DateTimeImmutable();
            $this->addSql("INSERT INTO site_option (name, value, description, created_at) VALUES ('{$option['name']}', '', '{$option['description']}', '{$dateTime->format('Y-m-d')}')");
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
