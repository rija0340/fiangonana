<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213161712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hira_choral DROP FOREIGN KEY FK_901B568548C3BDF');
        $this->addSql('DROP INDEX IDX_901B568548C3BDF ON hira_choral');
        $this->addSql('ALTER TABLE hira_choral DROP historique_hira_choral_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hira_choral ADD historique_hira_choral_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hira_choral ADD CONSTRAINT FK_901B568548C3BDF FOREIGN KEY (historique_hira_choral_id) REFERENCES historique_hira_choral (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_901B568548C3BDF ON hira_choral (historique_hira_choral_id)');
    }
}
