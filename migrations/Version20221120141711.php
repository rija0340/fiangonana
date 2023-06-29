<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120141711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre DROP FOREIGN KEY FK_D9A94145DF7140B1');
        $this->addSql('DROP INDEX IDX_D9A94145DF7140B1 ON registre');
        $this->addSql('ALTER TABLE registre DROP fianarana_lesona_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre ADD fianarana_lesona_id INT NOT NULL');
        $this->addSql('ALTER TABLE registre ADD CONSTRAINT FK_D9A94145DF7140B1 FOREIGN KEY (fianarana_lesona_id) REFERENCES fianarana_lesona (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D9A94145DF7140B1 ON registre (fianarana_lesona_id)');
    }
}
