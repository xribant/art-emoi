<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103171627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD event_registration_id INT NOT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517444AEEEB73 FOREIGN KEY (event_registration_id) REFERENCES event_registration (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_906517444AEEEB73 ON invoice (event_registration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517444AEEEB73');
        $this->addSql('DROP INDEX UNIQ_906517444AEEEB73 ON invoice');
        $this->addSql('ALTER TABLE invoice DROP event_registration_id');
    }
}
