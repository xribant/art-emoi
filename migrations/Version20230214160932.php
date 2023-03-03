<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214160932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F54BD7C4D');
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F71F7E88B');
        $this->addSql('DROP TABLE order_line_item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line_item (id INT AUTO_INCREMENT NOT NULL, main_order_id INT NOT NULL, event_id INT DEFAULT NULL, uid VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_28D1AD3F54BD7C4D (main_order_id), INDEX IDX_28D1AD3F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F54BD7C4D FOREIGN KEY (main_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
