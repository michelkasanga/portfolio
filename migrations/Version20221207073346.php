<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207073346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE header ADD COLUMN to_do CLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__header AS SELECT id, full_name, image_name, is_public, created_at, updated_at FROM header');
        $this->addSql('DROP TABLE header');
        $this->addSql('CREATE TABLE header (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(50) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, is_public BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO header (id, full_name, image_name, is_public, created_at, updated_at) SELECT id, full_name, image_name, is_public, created_at, updated_at FROM __temp__header');
        $this->addSql('DROP TABLE __temp__header');
    }
}
