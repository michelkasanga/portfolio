<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126091605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quality_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quality_id INTEGER NOT NULL, post VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, started_at INTEGER NOT NULL, ended_at VARCHAR(50) NOT NULL, content CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9F110BB5BCFC6D57 FOREIGN KEY (quality_id) REFERENCES quality (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9F110BB5BCFC6D57 ON quality_content (quality_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quality_content');
    }
}
