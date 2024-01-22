<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122141457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_week_day (user_id INT NOT NULL, week_day_id INT NOT NULL, PRIMARY KEY(user_id, week_day_id))');
        $this->addSql('CREATE INDEX IDX_C5E0F761A76ED395 ON user_week_day (user_id)');
        $this->addSql('CREATE INDEX IDX_C5E0F7617DB83875 ON user_week_day (week_day_id)');
        $this->addSql('ALTER TABLE user_week_day ADD CONSTRAINT FK_C5E0F761A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_week_day ADD CONSTRAINT FK_C5E0F7617DB83875 FOREIGN KEY (week_day_id) REFERENCES week_day (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_week_day DROP CONSTRAINT FK_C5E0F761A76ED395');
        $this->addSql('ALTER TABLE user_week_day DROP CONSTRAINT FK_C5E0F7617DB83875');
        $this->addSql('DROP TABLE user_week_day');
    }
}
