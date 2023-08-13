<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813122944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mpitondra_raharaha');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mpitondra_raharaha (id INT AUTO_INCREMENT NOT NULL, presides_id INT DEFAULT NULL, dimy_minitra_id INT DEFAULT NULL, lesona_id INT DEFAULT NULL, mpitory_teny_id INT DEFAULT NULL, alarobia_id INT DEFAULT NULL, presides_hariva_id INT DEFAULT NULL, tmt_id INT DEFAULT NULL, date_sabata DATETIME NOT NULL, INDEX IDX_D3AEF19920CD0815 (dimy_minitra_id), INDEX IDX_D3AEF199221114C5 (alarobia_id), INDEX IDX_D3AEF199251B1E06 (mpitory_teny_id), INDEX IDX_D3AEF1993D8E7661 (tmt_id), INDEX IDX_D3AEF1996F214B35 (presides_id), INDEX IDX_D3AEF199DCEFFA90 (lesona_id), INDEX IDX_D3AEF199FAD35259 (presides_hariva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF19920CD0815 FOREIGN KEY (dimy_minitra_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF199221114C5 FOREIGN KEY (alarobia_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF199251B1E06 FOREIGN KEY (mpitory_teny_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF1993D8E7661 FOREIGN KEY (tmt_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF1996F214B35 FOREIGN KEY (presides_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF199DCEFFA90 FOREIGN KEY (lesona_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mpitondra_raharaha ADD CONSTRAINT FK_D3AEF199FAD35259 FOREIGN KEY (presides_hariva_id) REFERENCES mambra (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
