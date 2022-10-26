<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023161516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount_event DROP FOREIGN KEY FK_1084D2304C7C611F');
        $this->addSql('ALTER TABLE discount_event DROP FOREIGN KEY FK_1084D23071F7E88B');
        $this->addSql('DROP TABLE discount_event');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74C7C611F');
        $this->addSql('DROP INDEX IDX_3BAE0AA74C7C611F ON event');
        $this->addSql('ALTER TABLE event DROP discount_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discount_event (discount_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_1084D23071F7E88B (event_id), INDEX IDX_1084D2304C7C611F (discount_id), PRIMARY KEY(discount_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE discount_event ADD CONSTRAINT FK_1084D2304C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discount_event ADD CONSTRAINT FK_1084D23071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD discount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3BAE0AA74C7C611F ON event (discount_id)');
    }
}
