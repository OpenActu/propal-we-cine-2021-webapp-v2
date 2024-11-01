<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101040321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_movie_genre (movie_id INT NOT NULL, movie_genre_id INT NOT NULL, PRIMARY KEY(movie_id, movie_genre_id))');
        $this->addSql('CREATE INDEX IDX_D294A5938F93B6FC ON movie_movie_genre (movie_id)');
        $this->addSql('CREATE INDEX IDX_D294A5939E604892 ON movie_movie_genre (movie_genre_id)');
        $this->addSql('CREATE TABLE movie_genre (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE movie_movie_genre ADD CONSTRAINT FK_D294A5938F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_movie_genre ADD CONSTRAINT FK_D294A5939E604892 FOREIGN KEY (movie_genre_id) REFERENCES movie_genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_movie_genre DROP CONSTRAINT FK_D294A5938F93B6FC');
        $this->addSql('ALTER TABLE movie_movie_genre DROP CONSTRAINT FK_D294A5939E604892');
        $this->addSql('DROP TABLE movie_movie_genre');
        $this->addSql('DROP TABLE movie_genre');
    }
}
