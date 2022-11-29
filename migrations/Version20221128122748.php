<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128122748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD COLUMN degree VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__about AS SELECT id, title, full_name, image_name, birthday, experience, phone, email, address, freelance, detail, created_at, updated_at FROM about');
        $this->addSql('DROP TABLE about');
        $this->addSql('CREATE TABLE about (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, full_name VARCHAR(50) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, birthday DATE NOT NULL, experience INTEGER DEFAULT NULL, phone INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, address CLOB NOT NULL, freelance BOOLEAN NOT NULL, detail CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO about (id, title, full_name, image_name, birthday, experience, phone, email, address, freelance, detail, created_at, updated_at) SELECT id, title, full_name, image_name, birthday, experience, phone, email, address, freelance, detail, created_at, updated_at FROM __temp__about');
        $this->addSql('DROP TABLE __temp__about');
    }
}
