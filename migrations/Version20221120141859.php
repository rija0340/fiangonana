<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120141859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fianarana_lesona ADD registre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fianarana_lesona ADD CONSTRAINT FK_F42F21C95678EFCA FOREIGN KEY (registre_id) REFERENCES registre (id)');
        $this->addSql('CREATE INDEX IDX_F42F21C95678EFCA ON fianarana_lesona (registre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fianarana_lesona DROP FOREIGN KEY FK_F42F21C95678EFCA');
        $this->addSql('DROP INDEX IDX_F42F21C95678EFCA ON fianarana_lesona');
        $this->addSql('ALTER TABLE fianarana_lesona DROP registre_id');
    }
}
