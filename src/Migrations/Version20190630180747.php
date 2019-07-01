<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190630180747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs ADD user_id INT NOT NULL, ADD location LONGTEXT DEFAULT NULL, CHANGE title title LONGTEXT DEFAULT NULL, CHANGE comapny_name comapny_name LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A8936DC5A76ED395 ON jobs (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC5A76ED395');
        $this->addSql('DROP INDEX IDX_A8936DC5A76ED395 ON jobs');
        $this->addSql('ALTER TABLE jobs DROP user_id, DROP location, CHANGE title title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comapny_name comapny_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
