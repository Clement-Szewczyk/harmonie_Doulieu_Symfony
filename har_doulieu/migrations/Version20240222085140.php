<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222085140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument ADD locataire_eleves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD66CBD18E FOREIGN KEY (locataire_eleves_id) REFERENCES eleves (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD66CBD18E ON instrument (locataire_eleves_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD66CBD18E');
        $this->addSql('DROP INDEX IDX_3CBF69DD66CBD18E ON instrument');
        $this->addSql('ALTER TABLE instrument DROP locataire_eleves_id');
    }
}
