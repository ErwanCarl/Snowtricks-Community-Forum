<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120095425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message CHANGE creation_date creation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE snowtrick CHANGE creation_date creation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE modification_date modification_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) NOT NULL, ADD logo VARCHAR(255) DEFAULT NULL, CHANGE validate_account validate_account TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message CHANGE creation_date creation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE snowtrick CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE modification_date modification_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP password, DROP logo, CHANGE validate_account validate_account INT NOT NULL');
    }
}
