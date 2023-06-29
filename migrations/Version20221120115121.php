<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120115121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fianarana_lesona (id INT AUTO_INCREMENT NOT NULL, mambra_id INT NOT NULL, presence TINYINT(1) NOT NULL, nombre INT NOT NULL, INDEX IDX_F42F21C961B16EE7 (mambra_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fianarana_lesona ADD CONSTRAINT FK_F42F21C961B16EE7 FOREIGN KEY (mambra_id) REFERENCES mambra (id)');
        $this->addSql('ALTER TABLE registre ADD kilasy_id INT NOT NULL, ADD fianarana_lesona_id INT NOT NULL');
        $this->addSql('ALTER TABLE registre ADD CONSTRAINT FK_D9A9414549602302 FOREIGN KEY (kilasy_id) REFERENCES kilasy (id)');
        $this->addSql('ALTER TABLE registre ADD CONSTRAINT FK_D9A94145DF7140B1 FOREIGN KEY (fianarana_lesona_id) REFERENCES fianarana_lesona (id)');
        $this->addSql('CREATE INDEX IDX_D9A9414549602302 ON registre (kilasy_id)');
        $this->addSql('CREATE INDEX IDX_D9A94145DF7140B1 ON registre (fianarana_lesona_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre DROP FOREIGN KEY FK_D9A94145DF7140B1');
        $this->addSql('DROP TABLE fianarana_lesona');
        $this->addSql('ALTER TABLE registre DROP FOREIGN KEY FK_D9A9414549602302');
        $this->addSql('DROP INDEX IDX_D9A9414549602302 ON registre');
        $this->addSql('DROP INDEX IDX_D9A94145DF7140B1 ON registre');
        $this->addSql('ALTER TABLE registre DROP kilasy_id, DROP fianarana_lesona_id');
    }
}
