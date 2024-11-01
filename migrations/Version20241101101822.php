<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101101822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD runtime INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ALTER popularity SET NOT NULL');
        $this->addSql('ALTER TABLE movie ALTER vote_average SET NOT NULL');
        $this->addSql('ALTER TABLE movie ALTER vote_count SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP runtime');
        $this->addSql('ALTER TABLE movie ALTER popularity DROP NOT NULL');
        $this->addSql('ALTER TABLE movie ALTER vote_average DROP NOT NULL');
        $this->addSql('ALTER TABLE movie ALTER vote_count DROP NOT NULL');
    }
}
