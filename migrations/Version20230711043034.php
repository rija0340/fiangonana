<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230711043034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hira DROP FOREIGN KEY FK_BF6CBAE5F6985D08');
        $this->addSql('ALTER TABLE tononkira DROP FOREIGN KEY FK_CA39BD6C9346BC85');
        $this->addSql('ALTER TABLE hira DROP FOREIGN KEY FK_BF6CBAE5C54C8C93');
        $this->addSql('DROP TABLE cle');
        $this->addSql('DROP TABLE hira');
        $this->addSql('DROP TABLE tononkira');
        $this->addSql('DROP TABLE type_hira');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cle (id INT AUTO_INCREMENT NOT NULL, cle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE hira (id INT AUTO_INCREMENT NOT NULL, cle_id INT DEFAULT NULL, type_id INT DEFAULT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numero INT DEFAULT NULL, INDEX IDX_BF6CBAE5F6985D08 (cle_id), INDEX IDX_BF6CBAE5C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tononkira (id INT AUTO_INCREMENT NOT NULL, hira_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CA39BD6C9346BC85 (hira_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_hira (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hira ADD CONSTRAINT FK_BF6CBAE5C54C8C93 FOREIGN KEY (type_id) REFERENCES type_hira (id)');
        $this->addSql('ALTER TABLE hira ADD CONSTRAINT FK_BF6CBAE5F6985D08 FOREIGN KEY (cle_id) REFERENCES cle (id)');
        $this->addSql('ALTER TABLE tononkira ADD CONSTRAINT FK_CA39BD6C9346BC85 FOREIGN KEY (hira_id) REFERENCES hira (id)');
    }
}
