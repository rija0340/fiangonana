<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101152235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kilasy DROP range_age');
        $this->addSql('ALTER TABLE kilasy ADD CONSTRAINT FK_52FD41071D31AF05 FOREIGN KEY (kilasy_lasitra_id) REFERENCES kilasy_lasitra (id)');
        $this->addSql('CREATE INDEX IDX_52FD41071D31AF05 ON kilasy (kilasy_lasitra_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kilasy DROP FOREIGN KEY FK_52FD41071D31AF05');
        $this->addSql('DROP INDEX IDX_52FD41071D31AF05 ON kilasy');
        $this->addSql('ALTER TABLE kilasy ADD range_age VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
