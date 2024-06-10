<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610103602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation CHANGE description description LONGTEXT DEFAULT NULL, CHANGE popularity popularity INT DEFAULT NULL, CHANGE price_level price_level VARCHAR(10) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE website_url website_url VARCHAR(255) DEFAULT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) DEFAULT NULL, CHANGE rating rating DOUBLE PRECISION DEFAULT NULL, CHANGE rating_image_url rating_image_url VARCHAR(255) DEFAULT NULL, CHANGE num_reviews num_reviews INT DEFAULT NULL, CHANGE photo_reference photo_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activity CHANGE website_url website_url VARCHAR(255) DEFAULT NULL, CHANGE popularity popularity INT DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE opening_hours opening_hours VARCHAR(255) DEFAULT NULL, CHANGE place_id place_id VARCHAR(255) DEFAULT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) DEFAULT NULL, CHANGE num_reviews num_reviews INT DEFAULT NULL, CHANGE rating rating DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE website_url website_url VARCHAR(255) DEFAULT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) DEFAULT NULL, CHANGE num_reviews num_reviews INT DEFAULT NULL, CHANGE price_level price_level VARCHAR(10) DEFAULT NULL, CHANGE popularity popularity INT DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE place_id place_id VARCHAR(255) DEFAULT NULL, CHANGE rating rating DOUBLE PRECISION DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation CHANGE description description VARCHAR(255) NOT NULL, CHANGE website_url website_url VARCHAR(255) NOT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) NOT NULL, CHANGE popularity popularity INT NOT NULL, CHANGE price_level price_level VARCHAR(255) NOT NULL, CHANGE rating rating VARCHAR(255) NOT NULL, CHANGE rating_image_url rating_image_url VARCHAR(255) NOT NULL, CHANGE num_reviews num_reviews VARCHAR(255) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE photo_url photo_reference VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activity CHANGE website_url website_url VARCHAR(255) NOT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) NOT NULL, CHANGE num_reviews num_reviews VARCHAR(255) NOT NULL, CHANGE popularity popularity INT NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE opening_hours opening_hours VARCHAR(255) NOT NULL, CHANGE place_id place_id VARCHAR(255) NOT NULL, CHANGE rating rating VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant CHANGE description description VARCHAR(1000) NOT NULL, CHANGE website_url website_url VARCHAR(255) NOT NULL, CHANGE tripadvisor_url tripadvisor_url VARCHAR(255) NOT NULL, CHANGE num_reviews num_reviews VARCHAR(255) NOT NULL, CHANGE price_level price_level VARCHAR(255) NOT NULL, CHANGE popularity popularity INT NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE place_id place_id VARCHAR(255) NOT NULL, CHANGE rating rating VARCHAR(255) DEFAULT NULL');
    }
}
