<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604220700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, vehicle_type VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, fuel_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DD545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_EA152DD545317D1 ON roadtrip (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DD545317D1');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP INDEX IDX_EA152DD545317D1 ON roadtrip');
        $this->addSql('ALTER TABLE roadtrip DROP vehicle_id');
    }
}
