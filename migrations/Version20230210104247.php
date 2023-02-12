<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210104247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, location VARCHAR(255) NOT NULL, public VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, nbr_sessions VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, trainer VARCHAR(255) NOT NULL, video_link VARCHAR(255) DEFAULT NULL, testimonial LONGTEXT DEFAULT NULL, hardware_list LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
    }
}
