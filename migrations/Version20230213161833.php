<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213161833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historique_hira_choral_hira_choral (historique_hira_choral_id INT NOT NULL, hira_choral_id INT NOT NULL, INDEX IDX_293EFC2348C3BDF (historique_hira_choral_id), INDEX IDX_293EFC23E73B2FF5 (hira_choral_id), PRIMARY KEY(historique_hira_choral_id, hira_choral_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_hira_choral_hira_choral ADD CONSTRAINT FK_293EFC2348C3BDF FOREIGN KEY (historique_hira_choral_id) REFERENCES historique_hira_choral (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historique_hira_choral_hira_choral ADD CONSTRAINT FK_293EFC23E73B2FF5 FOREIGN KEY (hira_choral_id) REFERENCES hira_choral (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE historique_hira_choral_hira_choral');
    }
}
