<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113154658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, snowtrick_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_FAB3FC16492EB8F3 (snowtrick_id), INDEX IDX_FAB3FC16A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, snowtrick_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_16DB4F89492EB8F3 (snowtrick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snowtrick (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trick_group_id INT NOT NULL, title VARCHAR(50) NOT NULL, author VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, INDEX IDX_9F4D0641A76ED395 (user_id), INDEX IDX_9F4D06419B875DF8 (trick_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_group (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, nickname VARCHAR(50) NOT NULL, mail VARCHAR(255) NOT NULL, roles JSON NOT NULL, validate_account INT NOT NULL, account_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, snowtrick_id INT NOT NULL, url VARCHAR(255) NOT NULL, video_id VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C492EB8F3 (snowtrick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id)');
        $this->addSql('ALTER TABLE snowtrick ADD CONSTRAINT FK_9F4D0641A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE snowtrick ADD CONSTRAINT FK_9F4D06419B875DF8 FOREIGN KEY (trick_group_id) REFERENCES trick_group (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16492EB8F3');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16A76ED395');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89492EB8F3');
        $this->addSql('ALTER TABLE snowtrick DROP FOREIGN KEY FK_9F4D0641A76ED395');
        $this->addSql('ALTER TABLE snowtrick DROP FOREIGN KEY FK_9F4D06419B875DF8');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C492EB8F3');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE snowtrick');
        $this->addSql('DROP TABLE trick_group');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
