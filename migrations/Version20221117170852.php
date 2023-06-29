<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117170852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre DROP FOREIGN KEY FK_D9A9414549602302');
        $this->addSql('DROP INDEX IDX_D9A9414549602302 ON registre');
        $this->addSql('ALTER TABLE registre DROP kilasy_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre ADD kilasy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registre ADD CONSTRAINT FK_D9A9414549602302 FOREIGN KEY (kilasy_id) REFERENCES kilasy (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D9A9414549602302 ON registre (kilasy_id)');
    }
}
