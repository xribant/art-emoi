<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023154056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discount_event (discount_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_1084D2304C7C611F (discount_id), INDEX IDX_1084D23071F7E88B (event_id), PRIMARY KEY(discount_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discount_event ADD CONSTRAINT FK_1084D2304C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discount_event ADD CONSTRAINT FK_1084D23071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount_event DROP FOREIGN KEY FK_1084D2304C7C611F');
        $this->addSql('ALTER TABLE discount_event DROP FOREIGN KEY FK_1084D23071F7E88B');
        $this->addSql('DROP TABLE discount_event');
    }
}
