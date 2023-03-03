<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214162706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD workshop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA71FDCE57C ON event (workshop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71FDCE57C');
        $this->addSql('DROP INDEX IDX_3BAE0AA71FDCE57C ON event');
        $this->addSql('ALTER TABLE event DROP workshop_id');
    }
}
