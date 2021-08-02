<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904103928 extends AbstractMigration
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
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DELETE FROM users');
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('77515', 'ROLE_ADMIN', 'Новожилов Антон', 'ANovozhilov@action-press.ru', true, '2020-07-28 17:32:45', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('77605', 'ROLE_ADMIN', 'Осипов Алексей', 'osipov@action-media.ru', true, '2020-07-27 18:38:14', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('79618', 'ROLE_ADMIN', 'Чернова Наталия', 'chernova@action-media.ru', true, '2020-07-28 12:47:36', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('72143', 'ROLE_ADMIN', 'Герасимов Алексей', 'a.gerasimov@action-media.ru', true, '2020-07-17 18:41:30', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('28957', 'ROLE_ADMIN', 'Шишкарёва Татьяна', 'shishkareva@action-media.ru', true, '2020-07-30 14:49:05', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('29442', 'ROLE_ADMIN', 'Щелконогов Алексей', 'schelkonogov@action-media.ru', true, '2020-07-22 20:58:42', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('37166', 'ROLE_ADMIN', 'Попович Дарья', 'dpopovich@mcfr.ru', true, '2020-07-30 17:34:03', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('52727', 'ROLE_ADMIN', 'Дуткевич Татьяна', 'T.Dutkevich@action-media.ru', true, '2020-07-22 09:56:01', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('53319', 'ROLE_ADMIN', 'Холщевников Роман', 'kholshchevnikov@action-mcfr.ru', true, '2020-07-13 20:36:19', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('70783', 'ROLE_ADMIN', 'Белов Александр', 'belov@action-media.ru', true, '2020-07-22 10:05:45', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('74440', 'ROLE_ADMIN', 'Семоненко Станислав', 'semonenko@action-media.ru', true, '2020-08-11 18:25:52', null)");
        $this->addSql("INSERT INTO users (uuid, roles, name, email, is_active, created_at, deleted_at) VALUES ('86975', 'ROLE_ADMIN', 'Долгов Александр', 'dolgov@action-media.ru', true, '2020-06-01 00:00:00', null)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DELETE FROM users');
    }
}
