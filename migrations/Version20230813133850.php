<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813133850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD andraikitra_id INT NOT NULL, ADD mambra_id INT NOT NULL, ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF199ED17E065 FOREIGN KEY (andraikitra_id) REFERENCES raharaha (id)');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF19961B16EE7 FOREIGN KEY (mambra_id) REFERENCES mambra (id)');
        $this->addSql('CREATE INDEX IDX_D3AEF199ED17E065 ON mpitondra_raharaha (andraikitra_id)');
        $this->addSql('CREATE INDEX IDX_D3AEF19961B16EE7 ON mpitondra_raharaha (mambra_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mpitondra_raharaha DROP FOREIGN KEY FK_D3AEF199ED17E065');
        $this->addSql('ALTER TABLE mpitondra_raharaha DROP FOREIGN KEY FK_D3AEF19961B16EE7');
        $this->addSql('DROP INDEX IDX_D3AEF199ED17E065 ON mpitondra_raharaha');
        $this->addSql('DROP INDEX IDX_D3AEF19961B16EE7 ON mpitondra_raharaha');
        $this->addSql('ALTER TABLE mpitondra_raharaha DROP andraikitra_id, DROP mambra_id, DROP date');
    }
}
