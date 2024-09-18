<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802160445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE relachoix (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, comment VARCHAR(555) DEFAULT NULL, relach_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prospect ADD relachoix_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DAED20B5F FOREIGN KEY (relachoix_id) REFERENCES relachoix (id)');
        $this->addSql('CREATE INDEX IDX_C9CE8C7DAED20B5F ON prospect (relachoix_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DAED20B5F');
        $this->addSql('DROP TABLE relachoix');
        $this->addSql('DROP INDEX IDX_C9CE8C7DAED20B5F ON prospect');
        $this->addSql('ALTER TABLE prospect DROP relachoix_id');
    }
}
