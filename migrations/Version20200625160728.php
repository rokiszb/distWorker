<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625160728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__url AS SELECT id, url, status, http_code FROM url');
        $this->addSql('DROP TABLE url');
        $this->addSql('CREATE TABLE url (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL COLLATE BINARY, http_code INTEGER DEFAULT NULL, status VARCHAR(255) DEFAULT \'NEW\' NOT NULL)');
        $this->addSql('INSERT INTO url (id, url, status, http_code) SELECT id, url, status, http_code FROM __temp__url');
        $this->addSql('DROP TABLE __temp__url');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__url AS SELECT id, url, status, http_code FROM url');
        $this->addSql('DROP TABLE url');
        $this->addSql('CREATE TABLE url (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL, http_code INTEGER DEFAULT NULL, status VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO url (id, url, status, http_code) SELECT id, url, status, http_code FROM __temp__url');
        $this->addSql('DROP TABLE __temp__url');
    }
}
