<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025094946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workshop_infos (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, start_at TIME NOT NULL, stop_at TIME NOT NULL, price DOUBLE PRECISION NOT NULL, animator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_648D1771FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workshop_infos ADD CONSTRAINT FK_648D1771FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop_infos_workshop_location DROP FOREIGN KEY FK_31462AB7D7DB861F');
        $this->addSql('ALTER TABLE workshop_infos DROP FOREIGN KEY FK_648D1771FDCE57C');
        $this->addSql('DROP TABLE workshop_infos');
    }
}
