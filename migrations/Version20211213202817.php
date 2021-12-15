<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213202817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop_infos ADD workshop_id INT NOT NULL');
        $this->addSql('ALTER TABLE workshop_infos ADD CONSTRAINT FK_648D1771FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_648D1771FDCE57C ON workshop_infos (workshop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop_infos DROP FOREIGN KEY FK_648D1771FDCE57C');
        $this->addSql('DROP INDEX UNIQ_648D1771FDCE57C ON workshop_infos');
        $this->addSql('ALTER TABLE workshop_infos DROP workshop_id');
    }
}
