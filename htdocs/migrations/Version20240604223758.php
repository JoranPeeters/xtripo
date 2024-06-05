<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604223758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roadtrip_roadtrip_type (roadtrip_id INT NOT NULL, roadtrip_type_id INT NOT NULL, INDEX IDX_E382046BCA4CCFF5 (roadtrip_id), INDEX IDX_E382046BF5268A97 (roadtrip_type_id), PRIMARY KEY(roadtrip_id, roadtrip_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roadtrip_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, popularity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip_roadtrip_type ADD CONSTRAINT FK_E382046BCA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_roadtrip_type ADD CONSTRAINT FK_E382046BF5268A97 FOREIGN KEY (roadtrip_type_id) REFERENCES roadtrip_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle ADD models LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP model');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip_roadtrip_type DROP FOREIGN KEY FK_E382046BCA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_roadtrip_type DROP FOREIGN KEY FK_E382046BF5268A97');
        $this->addSql('DROP TABLE roadtrip_roadtrip_type');
        $this->addSql('DROP TABLE roadtrip_type');
        $this->addSql('ALTER TABLE vehicle ADD model VARCHAR(255) NOT NULL, DROP models');
    }
}
