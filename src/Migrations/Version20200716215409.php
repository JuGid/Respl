<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716215409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE budget_line (id INT AUTO_INCREMENT NOT NULL, budget_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_ABD0B6A636ABA6B8 (budget_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, max DOUBLE PRECISION DEFAULT NULL, INDEX IDX_73F2F77B73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_line (id INT AUTO_INCREMENT NOT NULL, liste_id INT NOT NULL, nom VARCHAR(255) NOT NULL, lien LONGTEXT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, optionnel TINYINT(1) DEFAULT NULL, INDEX IDX_F0437425E85441D8 (liste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptabilite_line (id INT AUTO_INCREMENT NOT NULL, comptabilite_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, passif DOUBLE PRECISION DEFAULT NULL, actif DOUBLE PRECISION DEFAULT NULL, INDEX IDX_996A35174E455E4 (comptabilite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, etat VARCHAR(50) NOT NULL, creation DATETIME NOT NULL, INDEX IDX_9387207553C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptabilite (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_A737A41B73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_FCF22AF473A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget_line ADD CONSTRAINT FK_ABD0B6A636ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liste_line ADD CONSTRAINT FK_F0437425E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id)');
        $this->addSql('ALTER TABLE comptabilite_line ADD CONSTRAINT FK_996A35174E455E4 FOREIGN KEY (comptabilite_id) REFERENCES comptabilite (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207553C59D72 FOREIGN KEY (responsable_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comptabilite ADD CONSTRAINT FK_A737A41B73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF473A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B73A201E5');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207553C59D72');
        $this->addSql('ALTER TABLE comptabilite DROP FOREIGN KEY FK_A737A41B73A201E5');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF473A201E5');
        $this->addSql('ALTER TABLE budget_line DROP FOREIGN KEY FK_ABD0B6A636ABA6B8');
        $this->addSql('ALTER TABLE comptabilite_line DROP FOREIGN KEY FK_996A35174E455E4');
        $this->addSql('ALTER TABLE liste_line DROP FOREIGN KEY FK_F0437425E85441D8');
        $this->addSql('DROP TABLE budget_line');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE liste_line');
        $this->addSql('DROP TABLE comptabilite_line');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE comptabilite');
        $this->addSql('DROP TABLE liste');
    }
}
