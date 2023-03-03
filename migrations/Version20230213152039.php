<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213152039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71FDCE57C');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('DROP INDEX IDX_3BAE0AA71FDCE57C ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA764D218E ON event');
        $this->addSql('ALTER TABLE event ADD location VARCHAR(255) DEFAULT NULL, DROP workshop_id, DROP location_id, DROP archived, DROP presentiel');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD workshop_id INT NOT NULL, ADD location_id INT DEFAULT NULL, ADD archived TINYINT(1) NOT NULL, ADD presentiel TINYINT(1) NOT NULL, DROP location');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES workshop_location (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3BAE0AA71FDCE57C ON event (workshop_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA764D218E ON event (location_id)');
    }
}
