<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023150140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, uid VARCHAR(255) NOT NULL, rate INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD discount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA74C7C611F ON event (discount_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74C7C611F');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP INDEX IDX_3BAE0AA74C7C611F ON event');
        $this->addSql('ALTER TABLE event DROP discount_id');
    }
}
