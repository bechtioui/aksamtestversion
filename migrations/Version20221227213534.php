<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227213534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496C8A81A9');
        $this->addSql('DROP INDEX IDX_8D93D6496C8A81A9 ON user');
        $this->addSql('ALTER TABLE user CHANGE products_id teams_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D6365F12 FOREIGN KEY (teams_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D6365F12 ON user (teams_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D6365F12');
        $this->addSql('DROP INDEX IDX_8D93D649D6365F12 ON user');
        $this->addSql('ALTER TABLE user CHANGE teams_id products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6496C8A81A9 ON user (products_id)');
    }
}
