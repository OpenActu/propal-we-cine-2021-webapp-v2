<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101043347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie_country (movie_id INT NOT NULL, country_id INT NOT NULL, PRIMARY KEY(movie_id, country_id))');
        $this->addSql('CREATE INDEX IDX_73E58B488F93B6FC ON movie_country (movie_id)');
        $this->addSql('CREATE INDEX IDX_73E58B48F92F3E70 ON movie_country (country_id)');
        $this->addSql('ALTER TABLE movie_country ADD CONSTRAINT FK_73E58B488F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_country ADD CONSTRAINT FK_73E58B48F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_country DROP CONSTRAINT FK_73E58B488F93B6FC');
        $this->addSql('ALTER TABLE movie_country DROP CONSTRAINT FK_73E58B48F92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE movie_country');
    }
}