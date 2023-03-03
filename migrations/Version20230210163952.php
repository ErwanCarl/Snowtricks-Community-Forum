<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210163952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89492EB8F3');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F4D06412B36786B ON snowtrick (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F4D0641989D9B62 ON snowtrick (slug)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C492EB8F3');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89492EB8F3');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_9F4D06412B36786B ON snowtrick');
        $this->addSql('DROP INDEX UNIQ_9F4D0641989D9B62 ON snowtrick');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C492EB8F3');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C492EB8F3 FOREIGN KEY (snowtrick_id) REFERENCES snowtrick (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
