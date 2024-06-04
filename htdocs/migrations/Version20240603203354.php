<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603203354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accommodation (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vehicle_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, open_ai_output JSON NOT NULL, info LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EA152DDA76ED395 (user_id), INDEX IDX_EA152DD545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_accommodation (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, accommodation_id INT NOT NULL, day INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_49191153CA4CCFF5 (roadtrip_id), INDEX IDX_491911538F3692CD (accommodation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_activity (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, activity_id INT NOT NULL, day INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_AB29A745CA4CCFF5 (roadtrip_id), INDEX IDX_AB29A74581C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_country (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, country_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6319CF62CA4CCFF5 (roadtrip_id), INDEX IDX_6319CF62F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_type (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_87A3412ACA4CCFF5 (roadtrip_id), INDEX IDX_87A3412AC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_vehicle (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, vehicle_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2BEAE282CA4CCFF5 (roadtrip_id), INDEX IDX_2BEAE282545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, fuel_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', rented TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE waypoint (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, day INT NOT NULL, location_name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, coordinates VARCHAR(255) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B3DC5881CA4CCFF5 (roadtrip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DD545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE roadtrip_accommodation ADD CONSTRAINT FK_49191153CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_accommodation ADD CONSTRAINT FK_491911538F3692CD FOREIGN KEY (accommodation_id) REFERENCES accommodation (id)');
        $this->addSql('ALTER TABLE roadtrip_activity ADD CONSTRAINT FK_AB29A745CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_activity ADD CONSTRAINT FK_AB29A74581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE roadtrip_country ADD CONSTRAINT FK_6319CF62CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_country ADD CONSTRAINT FK_6319CF62F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE roadtrip_type ADD CONSTRAINT FK_87A3412ACA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_type ADD CONSTRAINT FK_87A3412AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE roadtrip_vehicle ADD CONSTRAINT FK_2BEAE282CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_vehicle ADD CONSTRAINT FK_2BEAE282545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC5881CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DDA76ED395');
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DD545317D1');
        $this->addSql('ALTER TABLE roadtrip_accommodation DROP FOREIGN KEY FK_49191153CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_accommodation DROP FOREIGN KEY FK_491911538F3692CD');
        $this->addSql('ALTER TABLE roadtrip_activity DROP FOREIGN KEY FK_AB29A745CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_activity DROP FOREIGN KEY FK_AB29A74581C06096');
        $this->addSql('ALTER TABLE roadtrip_country DROP FOREIGN KEY FK_6319CF62CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_country DROP FOREIGN KEY FK_6319CF62F92F3E70');
        $this->addSql('ALTER TABLE roadtrip_type DROP FOREIGN KEY FK_87A3412ACA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_type DROP FOREIGN KEY FK_87A3412AC54C8C93');
        $this->addSql('ALTER TABLE roadtrip_vehicle DROP FOREIGN KEY FK_2BEAE282CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_vehicle DROP FOREIGN KEY FK_2BEAE282545317D1');
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC5881CA4CCFF5');
        $this->addSql('DROP TABLE accommodation');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE roadtrip');
        $this->addSql('DROP TABLE roadtrip_accommodation');
        $this->addSql('DROP TABLE roadtrip_activity');
        $this->addSql('DROP TABLE roadtrip_country');
        $this->addSql('DROP TABLE roadtrip_type');
        $this->addSql('DROP TABLE roadtrip_vehicle');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE waypoint');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
