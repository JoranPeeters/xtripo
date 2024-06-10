<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610115510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, tripadvisor_url VARCHAR(255) DEFAULT NULL, popularity INT DEFAULT NULL, price_level VARCHAR(10) DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, rating_image_url VARCHAR(255) DEFAULT NULL, num_reviews INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, check_in DATE DEFAULT NULL, check_out DATE DEFAULT NULL, amenities JSON DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) DEFAULT NULL, category VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO place (name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, check_in, check_out, amenities, photo_url, place_id, category, created_at, updated_at)
                       SELECT name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, check_in, check_out, amenities, photo_url, place_id, "accommodation", created_at, updated_at
                       FROM accommodation');

        $this->addSql('INSERT INTO place (name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, opening_hours, photo_url, place_id, category, created_at, updated_at)
                       SELECT name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, opening_hours, photo_url, place_id, "restaurant", created_at, updated_at
                       FROM restaurant');

        $this->addSql('INSERT INTO place (name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, opening_hours, photo_url, place_id, category, created_at, updated_at)
                       SELECT name, description, website_url, tripadvisor_url, popularity, price_level, rating, rating_image_url, num_reviews, address, latitude, longitude, opening_hours, photo_url, place_id, "activity", created_at, updated_at
                       FROM activity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE place');
    }
}
