<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614233458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acces (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, access_date DATETIME DEFAULT NULL, logout_date DATETIME DEFAULT NULL, INDEX IDX_D0F43B10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, cmrl_id INT DEFAULT NULL, prospect_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(255) DEFAULT NULL, raison_sociale VARCHAR(255) DEFAULT NULL, adress LONGTEXT DEFAULT NULL, creat_at DATETIME DEFAULT NULL, INDEX IDX_C7440455296CD8AE (team_id), INDEX IDX_C7440455F8BA72B4 (cmrl_id), UNIQUE INDEX UNIQ_C7440455D182060A (prospect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, prospect_id INT DEFAULT NULL, team_id INT DEFAULT NULL, action_date DATETIME DEFAULT NULL, action_type VARCHAR(255) DEFAULT NULL, INDEX IDX_27BA704BD182060A (prospect_id), INDEX IDX_27BA704B296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, descrption VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prospect (id INT AUTO_INCREMENT NOT NULL, autor_id INT DEFAULT NULL, comrcl_id INT DEFAULT NULL, team_id INT DEFAULT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, gender SMALLINT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, adress LONGTEXT DEFAULT NULL, brith_at DATETIME DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, type_prospect VARCHAR(50) DEFAULT NULL, raison_sociale VARCHAR(255) DEFAULT NULL, code_post VARCHAR(255) DEFAULT NULL, gsm VARCHAR(255) DEFAULT NULL, assure VARCHAR(20) DEFAULT NULL, last_assure VARCHAR(20) DEFAULT NULL, motif_resil VARCHAR(50) DEFAULT NULL, motif_saise VARCHAR(255) DEFAULT NULL, creat_at DATETIME DEFAULT NULL, activites VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_C9CE8C7D14D45BBE (autor_id), INDEX IDX_C9CE8C7D10C5C333 (comrcl_id), INDEX IDX_C9CE8C7D296CD8AE (team_id), INDEX IDX_C9CE8C7D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relanced (id INT AUTO_INCREMENT NOT NULL, prospect_id INT DEFAULT NULL, motif_relanced VARCHAR(255) DEFAULT NULL, relaced_at DATETIME DEFAULT NULL, comment VARCHAR(515) DEFAULT NULL, INDEX IDX_4A8074F0D182060A (prospect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, teams_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender SMALLINT DEFAULT NULL, embuch_at DATETIME DEFAULT NULL, remuneration INT DEFAULT NULL, status SMALLINT NOT NULL, creat_at DATETIME DEFAULT NULL, last_login_date DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, logout_date DATETIME DEFAULT NULL, is_connect TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649D6365F12 (teams_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_fonction (user_id INT NOT NULL, fonction_id INT NOT NULL, INDEX IDX_E98D31BDA76ED395 (user_id), INDEX IDX_E98D31BD57889920 (fonction_id), PRIMARY KEY(user_id, fonction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_product (user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8B471AA7A76ED395 (user_id), INDEX IDX_8B471AA74584665A (product_id), PRIMARY KEY(user_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455F8BA72B4 FOREIGN KEY (cmrl_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D182060A FOREIGN KEY (prospect_id) REFERENCES prospect (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BD182060A FOREIGN KEY (prospect_id) REFERENCES prospect (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D10C5C333 FOREIGN KEY (comrcl_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE relanced ADD CONSTRAINT FK_4A8074F0D182060A FOREIGN KEY (prospect_id) REFERENCES prospect (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D6365F12 FOREIGN KEY (teams_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE user_fonction ADD CONSTRAINT FK_E98D31BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_fonction ADD CONSTRAINT FK_E98D31BD57889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B10A76ED395');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455296CD8AE');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455F8BA72B4');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D182060A');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BD182060A');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B296CD8AE');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D14D45BBE');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D10C5C333');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D296CD8AE');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D4584665A');
        $this->addSql('ALTER TABLE relanced DROP FOREIGN KEY FK_4A8074F0D182060A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D6365F12');
        $this->addSql('ALTER TABLE user_fonction DROP FOREIGN KEY FK_E98D31BDA76ED395');
        $this->addSql('ALTER TABLE user_fonction DROP FOREIGN KEY FK_E98D31BD57889920');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA7A76ED395');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA74584665A');
        $this->addSql('DROP TABLE acces');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE prospect');
        $this->addSql('DROP TABLE relanced');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_fonction');
        $this->addSql('DROP TABLE user_product');
    }
}
