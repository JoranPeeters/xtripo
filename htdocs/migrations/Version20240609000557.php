<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609000557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add starting_point_id field to roadtrip table and set up foreign key constraints';
    }

    public function up(Schema $schema): void
    {
        // Check if the column already exists
        $schemaManager = $this->connection->getSchemaManager();
        $columns = $schemaManager->listTableColumns('roadtrip');

        if (!array_key_exists('starting_point_id', $columns)) {
            // Step 1: Add the starting_point_id field as nullable
            $this->addSql('ALTER TABLE roadtrip ADD starting_point_id INT DEFAULT NULL');
        }

        // Step 2: Update existing records to set a default starting_point_id
        // Assuming city with ID 1 exists. Adjust this value based on your data.
        $this->addSql('UPDATE roadtrip SET starting_point_id = 1 WHERE starting_point_id IS NULL');

        // Step 3: Make the starting_point_id field non-nullable
        $this->addSql('ALTER TABLE roadtrip MODIFY starting_point_id INT NOT NULL');

        // Step 4: Add foreign key constraint and index
        if (!isset($columns['starting_point_id'])) {
            $this->addSql('ALTER TABLE roadtrip ADD CONSTRAINT FK_EA152DDF39C0FE7 FOREIGN KEY (starting_point_id) REFERENCES city (id)');
            $this->addSql('CREATE INDEX IDX_EA152DDF39C0FE7 ON roadtrip (starting_point_id)');
        }

        // Remove the old starting_point field if it exists
        if (isset($columns['starting_point'])) {
            $this->addSql('ALTER TABLE roadtrip DROP starting_point');
        }
        $this->addSql('ALTER TABLE roadtrip ADD start_from_home TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Reverse the changes made in the up() method
        $this->addSql('ALTER TABLE roadtrip DROP FOREIGN KEY FK_EA152DDF39C0FE7');
        $this->addSql('DROP INDEX IDX_EA152DDF39C0FE7 ON roadtrip');
        $this->addSql('ALTER TABLE roadtrip ADD starting_point VARCHAR(255) DEFAULT NULL, DROP starting_point_id');
        $this->addSql('ALTER TABLE roadtrip DROP start_from_home');
    }
}
