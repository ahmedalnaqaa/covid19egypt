<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200416000016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cases (id INT AUTO_INCREMENT NOT NULL, total_cases SMALLINT DEFAULT 0 NOT NULL, total_recovered SMALLINT DEFAULT 0 NOT NULL, total_po_to_ne SMALLINT DEFAULT 0 NOT NULL, total_deaths SMALLINT DEFAULT 0 NOT NULL, new_daily_cases SMALLINT DEFAULT 0 NOT NULL, new_daily_recovered SMALLINT DEFAULT 0 NOT NULL, new_daily_po_to_ne SMALLINT DEFAULT 0 NOT NULL, new_daily_deaths SMALLINT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cases');
    }
}
