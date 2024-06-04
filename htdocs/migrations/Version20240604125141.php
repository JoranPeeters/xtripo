<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604125141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DD545317D1');
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DDA76ED395');
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DDC453EA47');
        $this->addSql('DROP INDEX IDX_EA152DDA76ED395 ON roadtrip');
        $this->addSql('DROP INDEX IDX_EA152DD545317D1 ON roadtrip');
        $this->addSql('DROP INDEX IDX_EA152DDC453EA47 ON roadtrip');
        $this->addSql('ALTER TABLE roadtrip DROP user_id, DROP vehicle_id, DROP rental_vehicle_id, CHANGE trip_preferences type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip ADD user_id INT NOT NULL, ADD vehicle_id INT DEFAULT NULL, ADD rental_vehicle_id INT DEFAULT NULL, CHANGE type trip_preferences VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DD545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DDC453EA47 FOREIGN KEY (rental_vehicle_id) REFERENCES rental_vehicle (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EA152DDA76ED395 ON roadtrip (user_id)');
        $this->addSql('CREATE INDEX IDX_EA152DD545317D1 ON roadtrip (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_EA152DDC453EA47 ON roadtrip (rental_vehicle_id)');
    }
}
