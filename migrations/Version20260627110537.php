<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260627110537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attempt (id INT AUTO_INCREMENT NOT NULL, proposed_word VARCHAR(30) NOT NULL, attempt_number INT NOT NULL, game_id INT NOT NULL, INDEX IDX_18EC0266E48FD905 (game_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(30) NOT NULL, attempts_count INT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_232B318CA76ED395 (user_id), INDEX IDX_232B318CE357438D (word_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(30) NOT NULL, length INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE attempt ADD CONSTRAINT FK_18EC0266E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE357438D FOREIGN KEY (word_id) REFERENCES word (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attempt DROP FOREIGN KEY FK_18EC0266E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA76ED395');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE357438D');
        $this->addSql('DROP TABLE attempt');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE word');
    }
}
