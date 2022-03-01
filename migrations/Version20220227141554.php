<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227141554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, programmes_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C53D045FA0A1C920 (programmes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_guide (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_transport (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, capacite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, guide_id INT DEFAULT NULL, transport_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, date DATE NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_3DDCB9FF12469DE2 (category_id), INDEX IDX_3DDCB9FFF6203804 (statut_id), INDEX IDX_3DDCB9FFD7ED1D4B (guide_id), INDEX IDX_3DDCB9FF9909C13F (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA0A1C920 FOREIGN KEY (programmes_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFD7ED1D4B FOREIGN KEY (guide_id) REFERENCES option_guide (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF9909C13F FOREIGN KEY (transport_id) REFERENCES option_transport (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF12469DE2');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFD7ED1D4B');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF9909C13F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA0A1C920');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFF6203804');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE option_guide');
        $this->addSql('DROP TABLE option_transport');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE user');
    }
}
