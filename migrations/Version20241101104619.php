<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101104619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie_language (movie_id INT NOT NULL, language_id INT NOT NULL, PRIMARY KEY(movie_id, language_id))');
        $this->addSql('CREATE INDEX IDX_82DEA388F93B6FC ON movie_language (movie_id)');
        $this->addSql('CREATE INDEX IDX_82DEA3882F1BAF4 ON movie_language (language_id)');
        $this->addSql('ALTER TABLE movie_language ADD CONSTRAINT FK_82DEA388F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_language ADD CONSTRAINT FK_82DEA3882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_language DROP CONSTRAINT FK_82DEA388F93B6FC');
        $this->addSql('ALTER TABLE movie_language DROP CONSTRAINT FK_82DEA3882F1BAF4');
        $this->addSql('DROP TABLE movie_language');
    }
}
