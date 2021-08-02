<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DateTimeImmutable;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026133943 extends AbstractMigration
{
    private string $siteOptionName = 'skillsGuid';
    private string $siteOptionDescription = 'GUID для работы с Skill API V2';
    private array $guids = [
        'er.glavbukh.ru' => 'acb8e49a-c541-4311-9e29-c44917014a07',
        'er.law.ru' => '187cda57-2aa8-4c13-be16-8ef9dcf309f3',
        'er.1glms.ru' => '5a802a09-434a-4ce5-b0de-87feaa68af52',
        'na.fd.ru' => '6c844642-d9d4-4e00-9e74-023d7693ac0a',
        'er.otruda.ru' => '402818a3-3718-4318-9340-d7ce8d661276',
        'er.gzakypki.ru' => 'a92995f7-bc4d-49f3-897f-07fe27fd40a0',
        'er.gkh.ru' => 'bb4e3c03-78a8-4384-beb1-f3a81872951f',
        'erro.menobr.ru' => 'f14a0315-406c-48d0-aaf3-4ca5e811b0c9',
        'er.budgetnik.ru' => 'ebf7763f-6e4d-42aa-bbff-857637345c45',
    ];

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        if (isset($this->guids[getenv('REGISTRY_DOMAIN')])) {
            $guid = $this->guids[getenv('REGISTRY_DOMAIN')];
            $dateTime = new DateTimeImmutable();
            $this->addSql("INSERT INTO site_option (name, value, description, created_at) VALUES ('{$this->siteOptionName}', '$guid', '{$this->siteOptionDescription}', '{$dateTime->format('Y-m-d')}')");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DELETE FROM site_option WHERE name = '{$this->siteOptionName}'");
    }
}
