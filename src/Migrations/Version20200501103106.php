<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501103106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tests ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5E64D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_1260FC5E64D218E ON tests (location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tests DROP FOREIGN KEY FK_1260FC5E64D218E');
        $this->addSql('DROP INDEX IDX_1260FC5E64D218E ON tests');
        $this->addSql('ALTER TABLE tests DROP location_id');
    }
}
