<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817162314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_collection ADD quantity INT DEFAULT NULL, ADD favourite TINYINT(1) DEFAULT NULL, ADD tradable TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE collect DROP quantity, DROP favourite, DROP tradable');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collect ADD quantity INT DEFAULT NULL, ADD favourite TINYINT(1) NOT NULL, ADD tradable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE card_collection DROP quantity, DROP favourite, DROP tradable');
    }
}
