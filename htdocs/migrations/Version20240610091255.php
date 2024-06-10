<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610091255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, tripadvisor_url VARCHAR(255) NOT NULL, num_reviews VARCHAR(255) NOT NULL, price_level VARCHAR(255) NOT NULL, popularity INT NOT NULL, address VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, opening_hours VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) NOT NULL, rating VARCHAR(255) DEFAULT NULL, rating_image_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_restaurants (roadtrip_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_9FA72F40CA4CCFF5 (roadtrip_id), INDEX IDX_9FA72F40B1E7706E (restaurant_id), PRIMARY KEY(roadtrip_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip_restaurants ADD CONSTRAINT FK_9FA72F40CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_restaurants ADD CONSTRAINT FK_9FA72F40B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip_restaurants DROP FOREIGN KEY FK_9FA72F40CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_restaurants DROP FOREIGN KEY FK_9FA72F40B1E7706E');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE roadtrip_restaurants');
    }
}
