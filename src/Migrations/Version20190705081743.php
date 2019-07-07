<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190705081743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE saved_job_searches ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE saved_job_searches ADD CONSTRAINT FK_8AF982C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8AF982C4A76ED395 ON saved_job_searches (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE saved_job_searches DROP FOREIGN KEY FK_8AF982C4A76ED395');
        $this->addSql('DROP INDEX IDX_8AF982C4A76ED395 ON saved_job_searches');
        $this->addSql('ALTER TABLE saved_job_searches DROP user_id');
    }
}
