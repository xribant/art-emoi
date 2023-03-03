<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214143330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F4584665A');
        $this->addSql('DROP INDEX UNIQ_28D1AD3F4584665A ON order_line_item');
        $this->addSql('ALTER TABLE order_line_item DROP product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28D1AD3F4584665A ON order_line_item (product_id)');
    }
}
