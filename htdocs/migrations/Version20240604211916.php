<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604211916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE waypoint (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, title VARCHAR(255) NOT NULL, day VARCHAR(255) NOT NULL, location_name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, advice VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, distance INT NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B3DC5881CA4CCFF5 (roadtrip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC5881CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC5881CA4CCFF5');
        $this->addSql('DROP TABLE waypoint');
    }
}
