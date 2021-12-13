<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211134158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD workshop_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('CREATE INDEX IDX_23A0E661FDCE57C ON article (workshop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661FDCE57C');
        $this->addSql('DROP INDEX IDX_23A0E661FDCE57C ON article');
        $this->addSql('ALTER TABLE article DROP workshop_id');
    }
}
