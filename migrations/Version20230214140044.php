<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214140044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD customer_id INT DEFAULT NULL, ADD total_amount DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON `order` (customer_id)');
        $this->addSql('ALTER TABLE payment ADD target_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5734BD51 FOREIGN KEY (target_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D5734BD51 ON payment (target_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('DROP INDEX IDX_F52993989395C3F3 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP customer_id, DROP total_amount');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5734BD51');
        $this->addSql('DROP INDEX IDX_6D28840D5734BD51 ON payment');
        $this->addSql('ALTER TABLE payment DROP target_order_id');
    }
}
