<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118100240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE matche_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matche (id INT NOT NULL, user_first_id INT DEFAULT NULL, user_second_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FCAD5108C0865F ON matche (user_first_id)');
        $this->addSql('CREATE INDEX IDX_9FCAD510FF769628 ON matche (user_second_id)');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD5108C0865F FOREIGN KEY (user_first_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510FF769628 FOREIGN KEY (user_second_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE matche_id_seq CASCADE');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD5108C0865F');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510FF769628');
        $this->addSql('DROP TABLE matche');
    }
}
