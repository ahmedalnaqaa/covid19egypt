<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200607213104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cases CHANGE total_cases total_cases BIGINT DEFAULT 0 NOT NULL, CHANGE total_recovered total_recovered BIGINT DEFAULT 0 NOT NULL, CHANGE total_po_to_ne total_po_to_ne BIGINT DEFAULT 0 NOT NULL, CHANGE total_deaths total_deaths BIGINT DEFAULT 0 NOT NULL, CHANGE new_daily_cases new_daily_cases INT DEFAULT 0 NOT NULL, CHANGE new_daily_recovered new_daily_recovered INT DEFAULT 0 NOT NULL, CHANGE new_daily_po_to_ne new_daily_po_to_ne INT DEFAULT 0 NOT NULL, CHANGE new_daily_deaths new_daily_deaths INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cases CHANGE total_cases total_cases SMALLINT DEFAULT 0 NOT NULL, CHANGE total_recovered total_recovered SMALLINT DEFAULT 0 NOT NULL, CHANGE total_po_to_ne total_po_to_ne SMALLINT DEFAULT 0 NOT NULL, CHANGE total_deaths total_deaths SMALLINT DEFAULT 0 NOT NULL, CHANGE new_daily_cases new_daily_cases SMALLINT DEFAULT 0 NOT NULL, CHANGE new_daily_recovered new_daily_recovered SMALLINT DEFAULT 0 NOT NULL, CHANGE new_daily_po_to_ne new_daily_po_to_ne SMALLINT DEFAULT 0 NOT NULL, CHANGE new_daily_deaths new_daily_deaths SMALLINT DEFAULT 0 NOT NULL');
    }
}
