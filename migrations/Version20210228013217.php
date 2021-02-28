<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228013217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__aluno AS SELECT id, nome FROM aluno');
        $this->addSql('DROP TABLE aluno');
        $this->addSql('CREATE TABLE aluno (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL COLLATE BINARY, curso VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO aluno (id, nome) SELECT id, nome FROM __temp__aluno');
        $this->addSql('DROP TABLE __temp__aluno');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__aluno AS SELECT id, nome FROM aluno');
        $this->addSql('DROP TABLE aluno');
        $this->addSql('CREATE TABLE aluno (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, data_nascimento DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO aluno (id, nome) SELECT id, nome FROM __temp__aluno');
        $this->addSql('DROP TABLE __temp__aluno');
    }
}
