<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410231318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comptabilite ADD createur_id INT NOT NULL');
        $this->addSql('ALTER TABLE comptabilite ADD CONSTRAINT FK_A737A41B73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A737A41B73A201E5 ON comptabilite (createur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comptabilite DROP FOREIGN KEY FK_A737A41B73A201E5');
        $this->addSql('DROP INDEX IDX_A737A41B73A201E5 ON comptabilite');
        $this->addSql('ALTER TABLE comptabilite DROP createur_id');
    }
}
