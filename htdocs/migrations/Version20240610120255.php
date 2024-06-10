<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610120255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roadtrip_places (roadtrip_id INT NOT NULL, place_id INT NOT NULL, INDEX IDX_215681BACA4CCFF5 (roadtrip_id), INDEX IDX_215681BADA6A219 (place_id), PRIMARY KEY(roadtrip_id, place_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roadtrip_places ADD CONSTRAINT FK_215681BACA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_places ADD CONSTRAINT FK_215681BADA6A219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_accommodations DROP FOREIGN KEY FK_E925D6548F3692CD');
        $this->addSql('ALTER TABLE roadtrip_accommodations DROP FOREIGN KEY FK_E925D654CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_activities DROP FOREIGN KEY FK_49C528C981C06096');
        $this->addSql('ALTER TABLE roadtrip_activities DROP FOREIGN KEY FK_49C528C9CA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_restaurants DROP FOREIGN KEY FK_9FA72F40B1E7706E');
        $this->addSql('ALTER TABLE roadtrip_restaurants DROP FOREIGN KEY FK_9FA72F40CA4CCFF5');
        $this->addSql('DROP TABLE roadtrip_accommodations');
        $this->addSql('DROP TABLE roadtrip_activities');
        $this->addSql('DROP TABLE roadtrip_restaurants');
        $this->addSql('DROP TABLE accommodation');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE restaurant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roadtrip_accommodations (roadtrip_id INT NOT NULL, accommodation_id INT NOT NULL, INDEX IDX_E925D654CA4CCFF5 (roadtrip_id), INDEX IDX_E925D6548F3692CD (accommodation_id), PRIMARY KEY(roadtrip_id, accommodation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roadtrip_activities (roadtrip_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_49C528C9CA4CCFF5 (roadtrip_id), INDEX IDX_49C528C981C06096 (activity_id), PRIMARY KEY(roadtrip_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roadtrip_restaurants (roadtrip_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_9FA72F40CA4CCFF5 (roadtrip_id), INDEX IDX_9FA72F40B1E7706E (restaurant_id), PRIMARY KEY(roadtrip_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE roadtrip_accommodations ADD CONSTRAINT FK_E925D6548F3692CD FOREIGN KEY (accommodation_id) REFERENCES accommodation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_accommodations ADD CONSTRAINT FK_E925D654CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_activities ADD CONSTRAINT FK_49C528C981C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_activities ADD CONSTRAINT FK_49C528C9CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_restaurants ADD CONSTRAINT FK_9FA72F40B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_restaurants ADD CONSTRAINT FK_9FA72F40CA4CCFF5 FOREIGN KEY (roadtrip_id) REFERENCES roadtrip (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roadtrip_places DROP FOREIGN KEY FK_215681BACA4CCFF5');
        $this->addSql('ALTER TABLE roadtrip_places DROP FOREIGN KEY FK_215681BADA6A219');
        $this->addSql('DROP TABLE roadtrip_places');
    }
}
