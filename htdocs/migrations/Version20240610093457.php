<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610093457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roadtrip_accommodations (roadtrip_id INT NOT NULL, accommodation_id INT NOT NULL, INDEX IDX_E925D654CA4CCFF5 (roadtrip_id), INDEX IDX_E925D6548F3692CD (accommodation_id), PRIMARY KEY(roadtrip_id, accommodation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip_accommodations ADD CONSTRAINT FK_E925D654CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_accommodations ADD CONSTRAINT FK_E925D6548F3692CD FOREIGN KEY (accommodation_id) REFERENCES accommodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D385412CA4CCFF5');
        $this->addSql('DROP INDEX IDX_2D385412CA4CCFF5 ON accommodation');
        $this->addSql('ALTER TABLE accommodation ADD website_url VARCHAR(255) NOT NULL, ADD tripadvisor_url VARCHAR(255) NOT NULL, ADD rating VARCHAR(255) NOT NULL, ADD rating_image_url VARCHAR(255) NOT NULL, ADD num_reviews VARCHAR(255) NOT NULL, DROP roadtrip_id, DROP price, DROP room_type, CHANGE price_level price_level VARCHAR(255) NOT NULL, CHANGE check_in check_in DATE DEFAULT NULL, CHANGE check_out check_out DATE DEFAULT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip_accommodations DROP FOREIGN KEY FK_E925D654CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_accommodations DROP FOREIGN KEY FK_E925D6548F3692CD');
        $this->addSql('DROP TABLE roadtrip_accommodations');
        $this->addSql('ALTER TABLE accommodation ADD roadtrip_id INT NOT NULL, ADD price NUMERIC(10, 2) DEFAULT NULL, ADD room_type VARCHAR(255) DEFAULT NULL, DROP website_url, DROP tripadvisor_url, DROP rating, DROP rating_image_url, DROP num_reviews, CHANGE price_level price_level INT NOT NULL, CHANGE check_in check_in TIME DEFAULT NULL, CHANGE check_out check_out TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D385412CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2D385412CA4CCFF5 ON accommodation (roadtrip_id)');
        
    }
}
