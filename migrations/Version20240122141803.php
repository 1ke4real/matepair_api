<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122141803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_time_day (user_id INT NOT NULL, time_day_id INT NOT NULL, PRIMARY KEY(user_id, time_day_id))');
        $this->addSql('CREATE INDEX IDX_DFACA6FAA76ED395 ON user_time_day (user_id)');
        $this->addSql('CREATE INDEX IDX_DFACA6FA50340ED0 ON user_time_day (time_day_id)');
        $this->addSql('ALTER TABLE user_time_day ADD CONSTRAINT FK_DFACA6FAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_time_day ADD CONSTRAINT FK_DFACA6FA50340ED0 FOREIGN KEY (time_day_id) REFERENCES time_day (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_time_day DROP CONSTRAINT FK_DFACA6FAA76ED395');
        $this->addSql('ALTER TABLE user_time_day DROP CONSTRAINT FK_DFACA6FA50340ED0');
        $this->addSql('DROP TABLE user_time_day');
    }
}
