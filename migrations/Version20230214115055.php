<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214115055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, main_order_id INT NOT NULL, uid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_28D1AD3F4584665A (product_id), INDEX IDX_28D1AD3F54BD7C4D (main_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_line_item ADD CONSTRAINT FK_28D1AD3F54BD7C4D FOREIGN KEY (main_order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F4584665A');
        $this->addSql('ALTER TABLE order_line_item DROP FOREIGN KEY FK_28D1AD3F54BD7C4D');
        $this->addSql('DROP TABLE order_line_item');
    }
}
