<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101104356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_production_country (movie_id INT NOT NULL, country_id INT NOT NULL, PRIMARY KEY(movie_id, country_id))');
        $this->addSql('CREATE INDEX IDX_483A6E158F93B6FC ON movie_production_country (movie_id)');
        $this->addSql('CREATE INDEX IDX_483A6E15F92F3E70 ON movie_production_country (country_id)');
        $this->addSql('ALTER TABLE movie_production_country ADD CONSTRAINT FK_483A6E158F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_production_country ADD CONSTRAINT FK_483A6E15F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_production_country DROP CONSTRAINT FK_483A6E158F93B6FC');
        $this->addSql('ALTER TABLE movie_production_country DROP CONSTRAINT FK_483A6E15F92F3E70');
        $this->addSql('DROP TABLE movie_production_country');
    }
}
