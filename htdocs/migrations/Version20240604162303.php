<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604162303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roadtrip_type (id INT AUTO_INCREMENT NOT NULL, roadtrip_id INT NOT NULL, type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_87A3412ACA4CCFF5 (roadtrip_id), INDEX IDX_87A3412AC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip_type ADD CONSTRAINT FK_87A3412ACA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id)');
        $this->addSql('ALTER TABLE roadtrip_type ADD CONSTRAINT FK_87A3412AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip_type DROP FOREIGN KEY FK_87A3412ACA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_type DROP FOREIGN KEY FK_87A3412AC54C8C93');
        $this->addSql('DROP TABLE roadtrip_type');
    }
}
