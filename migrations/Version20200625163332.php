<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625163332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__job AS SELECT id, url, status, http_code FROM job');
        $this->addSql('DROP TABLE job');
        $this->addSql('CREATE TABLE job (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL COLLATE BINARY, http_code INTEGER DEFAULT NULL, status VARCHAR(255) DEFAULT \'NEW\')');
        $this->addSql('INSERT INTO job (id, url, status, http_code) SELECT id, url, status, http_code FROM __temp__job');
        $this->addSql('DROP TABLE __temp__job');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__job AS SELECT id, url, status, http_code FROM job');
        $this->addSql('DROP TABLE job');
        $this->addSql('CREATE TABLE job (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL, http_code INTEGER DEFAULT NULL, status VARCHAR(255) DEFAULT \'NEW\' NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO job (id, url, status, http_code) SELECT id, url, status, http_code FROM __temp__job');
        $this->addSql('DROP TABLE __temp__job');
    }
}
