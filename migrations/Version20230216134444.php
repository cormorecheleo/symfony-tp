<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216134444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT NOT NULL, owned_thread_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, is_deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6DC044C58FDDAB70 (owner_id_id), INDEX IDX_6DC044C5A6A83D22 (owned_thread_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_request (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, group_id_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BD97DB939D86650F (user_id_id), UNIQUE INDEX UNIQ_BD97DB932F68B530 (group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE members (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE members_user (members_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C2F9F6ECBD01F5ED (members_id), INDEX IDX_C2F9F6ECA76ED395 (user_id), PRIMARY KEY(members_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE members_group (members_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_CB337982BD01F5ED (members_id), INDEX IDX_CB337982FE54D947 (group_id), PRIMARY KEY(members_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, thread_id_id INT NOT NULL, owner_id_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', masked TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_B6BD307F75C0816C (thread_id_id), UNIQUE INDEX UNIQ_B6BD307F8FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_31204C838FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C58FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5A6A83D22 FOREIGN KEY (owned_thread_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB939D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB932F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE members_user ADD CONSTRAINT FK_C2F9F6ECBD01F5ED FOREIGN KEY (members_id) REFERENCES members (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members_user ADD CONSTRAINT FK_C2F9F6ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members_group ADD CONSTRAINT FK_CB337982BD01F5ED FOREIGN KEY (members_id) REFERENCES members (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members_group ADD CONSTRAINT FK_CB337982FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F75C0816C FOREIGN KEY (thread_id_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C838FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C58FDDAB70');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5A6A83D22');
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB939D86650F');
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB932F68B530');
        $this->addSql('ALTER TABLE members_user DROP FOREIGN KEY FK_C2F9F6ECBD01F5ED');
        $this->addSql('ALTER TABLE members_user DROP FOREIGN KEY FK_C2F9F6ECA76ED395');
        $this->addSql('ALTER TABLE members_group DROP FOREIGN KEY FK_CB337982BD01F5ED');
        $this->addSql('ALTER TABLE members_group DROP FOREIGN KEY FK_CB337982FE54D947');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F75C0816C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8FDDAB70');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C838FDDAB70');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_request');
        $this->addSql('DROP TABLE members');
        $this->addSql('DROP TABLE members_user');
        $this->addSql('DROP TABLE members_group');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE thread');
    }
}
