<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200509042254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE isolations (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, temperature DOUBLE PRECISION DEFAULT NULL, blood_pressure VARCHAR(30) DEFAULT NULL, body_ache TINYINT(1) NOT NULL, diarrhea TINYINT(1) NOT NULL, headache TINYINT(1) NOT NULL, lose_of_taste TINYINT(1) NOT NULL, cough TINYINT(1) NOT NULL, sore_throat TINYINT(1) NOT NULL, runny_nose TINYINT(1) NOT NULL, dyspnea TINYINT(1) NOT NULL, describe_your_case LONGTEXT NOT NULL, doctor_comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_BAA6E491A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE isolations ADD CONSTRAINT FK_BAA6E491A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD location_id INT DEFAULT NULL, ADD assigned_doctor INT DEFAULT NULL, ADD symptoms_started_at DATE DEFAULT NULL, ADD isolation_started_at DATE DEFAULT NULL, ADD isolation_end_at DATE DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E964D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E987D65BE4 FOREIGN KEY (assigned_doctor) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E964D218E ON users (location_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E987D65BE4 ON users (assigned_doctor)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE isolations');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E964D218E');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E987D65BE4');
        $this->addSql('DROP INDEX IDX_1483A5E964D218E ON users');
        $this->addSql('DROP INDEX IDX_1483A5E987D65BE4 ON users');
        $this->addSql('ALTER TABLE users DROP location_id, DROP assigned_doctor, DROP symptoms_started_at, DROP isolation_started_at, DROP isolation_end_at, DROP created_at');
    }
}
