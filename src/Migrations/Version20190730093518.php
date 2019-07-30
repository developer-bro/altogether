<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730093518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25F7497F79');
        $this->addSql('DROP INDEX IDX_527EDB25F7497F79 ON task');
        $this->addSql('ALTER TABLE task ADD from_name VARCHAR(255) DEFAULT NULL, DROP from_name_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task ADD from_name_id INT DEFAULT NULL, DROP from_name');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25F7497F79 FOREIGN KEY (from_name_id) REFERENCES jobs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_527EDB25F7497F79 ON task (from_name_id)');
    }
}
