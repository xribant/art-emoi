<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213140823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP start_at, DROP end_at, DROP nbr_sessions, DROP present_location');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD start_at DATETIME NOT NULL, ADD end_at DATETIME NOT NULL, ADD nbr_sessions VARCHAR(255) DEFAULT NULL, ADD present_location VARCHAR(255) DEFAULT NULL');
    }
}
