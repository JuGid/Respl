<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410231841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget ADD createur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77B73A201E5 ON budget (createur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B73A201E5');
        $this->addSql('DROP INDEX IDX_73F2F77B73A201E5 ON budget');
        $this->addSql('ALTER TABLE budget DROP createur_id');
    }
}
