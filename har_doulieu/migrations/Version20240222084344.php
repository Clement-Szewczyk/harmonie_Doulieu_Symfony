<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222084344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instrument (id INT AUTO_INCREMENT NOT NULL, pupitre_id INT DEFAULT NULL, locataire_musicien_id INT DEFAULT NULL, numero_serie VARCHAR(50) NOT NULL, marque VARCHAR(255) NOT NULL, INDEX IDX_3CBF69DD9BD014B9 (pupitre_id), INDEX IDX_3CBF69DD6F31832F (locataire_musicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD9BD014B9 FOREIGN KEY (pupitre_id) REFERENCES pupitres (id)');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD6F31832F FOREIGN KEY (locataire_musicien_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD9BD014B9');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD6F31832F');
        $this->addSql('DROP TABLE instrument');
    }
}
