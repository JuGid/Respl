<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410233858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_FCF22AF473A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF473A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE liste_line ADD liste_id INT NOT NULL');
        $this->addSql('ALTER TABLE liste_line ADD CONSTRAINT FK_F0437425E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id)');
        $this->addSql('CREATE INDEX IDX_F0437425E85441D8 ON liste_line (liste_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE liste_line DROP FOREIGN KEY FK_F0437425E85441D8');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP INDEX IDX_F0437425E85441D8 ON liste_line');
        $this->addSql('ALTER TABLE liste_line DROP liste_id');
    }
}
