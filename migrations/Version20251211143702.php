<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211143702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tour AS SELECT id, title, description, price FROM tour');
        $this->addSql('DROP TABLE tour');
        $this->addSql('CREATE TABLE tour (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, price DOUBLE PRECISION NOT NULL, destination_id INTEGER NOT NULL, CONSTRAINT FK_6AD1F969816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tour (id, title, description, price) SELECT id, title, description, price FROM __temp__tour');
        $this->addSql('DROP TABLE __temp__tour');
        $this->addSql('CREATE INDEX IDX_6AD1F969816C6140 ON tour (destination_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tour AS SELECT id, title, description, price FROM tour');
        $this->addSql('DROP TABLE tour');
        $this->addSql('CREATE TABLE tour (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, destination VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tour (id, title, description, price) SELECT id, title, description, price FROM __temp__tour');
        $this->addSql('DROP TABLE __temp__tour');
    }
}
