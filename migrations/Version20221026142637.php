<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026142637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_registration ADD discount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD544C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('CREATE INDEX IDX_8FBBAD544C7C611F ON event_registration (discount_id)');
        $this->addSql('ALTER TABLE workshop_infos DROP duration');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD544C7C611F');
        $this->addSql('DROP INDEX IDX_8FBBAD544C7C611F ON event_registration');
        $this->addSql('ALTER TABLE event_registration DROP discount_id');
        $this->addSql('ALTER TABLE workshop_infos ADD duration VARCHAR(255) NOT NULL');
    }
}
