<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214143520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_28D1AD3F71F7E88B ON order_line_item (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F71F7E88B');
        $this->addSql('DROP INDEX IDX_28D1AD3F71F7E88B ON order_line_item');
        $this->addSql('ALTER TABLE order_line_item DROP event_id');
    }
}
