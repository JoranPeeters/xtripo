<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604222505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental_vehicle (id INT AUTO_INCREMENT NOT NULL, vehicle_type VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip ADD rental_vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DDC453EA47 FOREIGN KEY (rental_vehicle_id) REFERENCES rental_vehicle (id)');
        $this->addSql('CREATE INDEX IDX_EA152DDC453EA47 ON roadtrip (rental_vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DDC453EA47');
        $this->addSql('DROP TABLE rental_vehicle');
        $this->addSql('DROP INDEX IDX_EA152DDC453EA47 ON roadtrip');
        $this->addSql('ALTER TABLE roadtrip DROP rental_vehicle_id');
    }
}
