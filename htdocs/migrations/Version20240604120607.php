<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604120607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip ADD vehicle_type VARCHAR(255) NOT NULL, ADD vehicle_fuel VARCHAR(255) NOT NULL, ADD vehicle_model VARCHAR(255) NOT NULL, DROP car_type, DROP car_fuel, CHANGE rent_car rent_vehicle TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roadtrip ADD car_type VARCHAR(255) NOT NULL, ADD car_fuel VARCHAR(255) NOT NULL, DROP vehicle_type, DROP vehicle_fuel, DROP vehicle_model, CHANGE rent_vehicle rent_car TINYINT(1) NOT NULL');
    }
}
