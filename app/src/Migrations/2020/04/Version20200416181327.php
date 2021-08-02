<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200416181327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE specialist ALTER id2position TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER id2position DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER "position" TYPE INT USING (position::integer)');
        $this->addSql('ALTER TABLE specialist ALTER "position" DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER employment_type TYPE INT USING (employment_type::integer)');
        $this->addSql('ALTER TABLE specialist ALTER employment_type DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER schedule TYPE INT USING (schedule::integer)');
        $this->addSql('ALTER TABLE specialist ALTER schedule DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE specialist ALTER id2position TYPE INT');
        $this->addSql('ALTER TABLE specialist ALTER id2position DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER position TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER position DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER employment_type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER employment_type DROP DEFAULT');
        $this->addSql('ALTER TABLE specialist ALTER schedule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE specialist ALTER schedule DROP DEFAULT');
    }
}
