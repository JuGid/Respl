<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406134350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_line ADD budget_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget_line ADD CONSTRAINT FK_ABD0B6A636ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE INDEX IDX_ABD0B6A636ABA6B8 ON budget_line (budget_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_line DROP FOREIGN KEY FK_ABD0B6A636ABA6B8');
        $this->addSql('DROP INDEX IDX_ABD0B6A636ABA6B8 ON budget_line');
        $this->addSql('ALTER TABLE budget_line DROP budget_id');
    }
}
