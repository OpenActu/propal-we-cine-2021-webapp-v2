<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101104029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_production_company (movie_id INT NOT NULL, production_company_id INT NOT NULL, PRIMARY KEY(movie_id, production_company_id))');
        $this->addSql('CREATE INDEX IDX_54F6AE3C8F93B6FC ON movie_production_company (movie_id)');
        $this->addSql('CREATE INDEX IDX_54F6AE3CF13ABE4D ON movie_production_company (production_company_id)');
        $this->addSql('CREATE TABLE production_company (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, tmdb_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE movie_production_company ADD CONSTRAINT FK_54F6AE3C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_production_company ADD CONSTRAINT FK_54F6AE3CF13ABE4D FOREIGN KEY (production_company_id) REFERENCES production_company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_production_company DROP CONSTRAINT FK_54F6AE3C8F93B6FC');
        $this->addSql('ALTER TABLE movie_production_company DROP CONSTRAINT FK_54F6AE3CF13ABE4D');
        $this->addSql('DROP TABLE movie_production_company');
        $this->addSql('DROP TABLE production_company');
    }
}
