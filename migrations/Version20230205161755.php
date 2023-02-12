<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205161755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_23A0E661FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, uid VARCHAR(255) NOT NULL, rate INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_E1E0B40E71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, location_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, active TINYINT(1) NOT NULL, uid VARCHAR(255) NOT NULL, duration VARCHAR(255) DEFAULT NULL, archived TINYINT(1) NOT NULL, presentiel TINYINT(1) NOT NULL, INDEX IDX_3BAE0AA71FDCE57C (workshop_id), INDEX IDX_3BAE0AA764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_registration (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, discount_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, uid VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, tva VARCHAR(255) DEFAULT NULL, archived TINYINT(1) NOT NULL, discount_code VARCHAR(255) DEFAULT NULL, INDEX IDX_8FBBAD5471F7E88B (event_id), INDEX IDX_8FBBAD544C7C611F (discount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE free_registration (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, tva VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, workshop VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BB81E612989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, event_registration_id INT DEFAULT NULL, free_registration_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_906517444AEEEB73 (event_registration_id), UNIQUE INDEX UNIQ_906517443EAF604D (free_registration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, stripe_description VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, closure_date DATETIME NOT NULL, INDEX IDX_6D28840D9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_infos (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, start_at TIME NOT NULL, stop_at TIME NOT NULL, price DOUBLE PRECISION NOT NULL, animator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_648D1771FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_infos_workshop_location (workshop_infos_id INT NOT NULL, workshop_location_id INT NOT NULL, INDEX IDX_31462AB7D7DB861F (workshop_infos_id), INDEX IDX_31462AB73B124AC0 (workshop_location_id), PRIMARY KEY(workshop_infos_id, workshop_location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_video (id INT AUTO_INCREMENT NOT NULL, workshop_id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_944589361FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES workshop_location (id)');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_registration ADD CONSTRAINT FK_8FBBAD544C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE free_registration ADD CONSTRAINT FK_BB81E612989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517444AEEEB73 FOREIGN KEY (event_registration_id) REFERENCES event_registration (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517443EAF604D FOREIGN KEY (free_registration_id) REFERENCES free_registration (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE workshop_infos ADD CONSTRAINT FK_648D1771FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('ALTER TABLE workshop_infos_workshop_location ADD CONSTRAINT FK_31462AB7D7DB861F FOREIGN KEY (workshop_infos_id) REFERENCES workshop_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_infos_workshop_location ADD CONSTRAINT FK_31462AB73B124AC0 FOREIGN KEY (workshop_location_id) REFERENCES workshop_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_video ADD CONSTRAINT FK_944589361FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661FDCE57C');
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40E71F7E88B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71FDCE57C');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD5471F7E88B');
        $this->addSql('ALTER TABLE event_registration DROP FOREIGN KEY FK_8FBBAD544C7C611F');
        $this->addSql('ALTER TABLE free_registration DROP FOREIGN KEY FK_BB81E612989F1FD');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517444AEEEB73');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517443EAF604D');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9395C3F3');
        $this->addSql('ALTER TABLE workshop_infos DROP FOREIGN KEY FK_648D1771FDCE57C');
        $this->addSql('ALTER TABLE workshop_infos_workshop_location DROP FOREIGN KEY FK_31462AB7D7DB861F');
        $this->addSql('ALTER TABLE workshop_infos_workshop_location DROP FOREIGN KEY FK_31462AB73B124AC0');
        $this->addSql('ALTER TABLE workshop_video DROP FOREIGN KEY FK_944589361FDCE57C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_registration');
        $this->addSql('DROP TABLE free_registration');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workshop');
        $this->addSql('DROP TABLE workshop_infos');
        $this->addSql('DROP TABLE workshop_infos_workshop_location');
        $this->addSql('DROP TABLE workshop_location');
        $this->addSql('DROP TABLE workshop_video');
    }
}
