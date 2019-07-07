<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706120553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs ADD is_applied TINYINT(1) DEFAULT NULL, ADD is_follow_up TINYINT(1) DEFAULT NULL, ADD is_interview TINYINT(1) DEFAULT NULL, ADD is_post_interview_follow_up TINYINT(1) DEFAULT NULL, ADD date_initial_follow_up DATETIME DEFAULT NULL, ADD date_interview_prep DATETIME DEFAULT NULL, ADD date_interview DATETIME DEFAULT NULL, ADD date_thank_you_letter DATETIME DEFAULT NULL, ADD date_follow_up DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs DROP is_applied, DROP is_follow_up, DROP is_interview, DROP is_post_interview_follow_up, DROP date_initial_follow_up, DROP date_interview_prep, DROP date_interview, DROP date_thank_you_letter, DROP date_follow_up');
    }
}
