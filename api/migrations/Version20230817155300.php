<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817155300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card ADD game_id_id INT NOT NULL, ADD extension_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D34D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3CC00BA6B FOREIGN KEY (extension_id_id) REFERENCES extension (id)');
        $this->addSql('CREATE INDEX IDX_161498D34D77E7D8 ON card (game_id_id)');
        $this->addSql('CREATE INDEX IDX_161498D3CC00BA6B ON card (extension_id_id)');
        $this->addSql('ALTER TABLE card_collection ADD card_id_id INT NOT NULL, ADD collect_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_collection ADD CONSTRAINT FK_903FF83C47706F91 FOREIGN KEY (card_id_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE card_collection ADD CONSTRAINT FK_903FF83C6397A789 FOREIGN KEY (collect_id_id) REFERENCES collect (id)');
        $this->addSql('CREATE INDEX IDX_903FF83C47706F91 ON card_collection (card_id_id)');
        $this->addSql('CREATE INDEX IDX_903FF83C6397A789 ON card_collection (collect_id_id)');
        $this->addSql('ALTER TABLE collect ADD user_id_id INT NOT NULL, ADD game_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE collect ADD CONSTRAINT FK_A40662F49D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE collect ADD CONSTRAINT FK_A40662F44D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_A40662F49D86650F ON collect (user_id_id)');
        $this->addSql('CREATE INDEX IDX_A40662F44D77E7D8 ON collect (game_id_id)');
        $this->addSql('ALTER TABLE commentary ADD user_id_id INT NOT NULL, ADD card_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA47706F91 FOREIGN KEY (card_id_id) REFERENCES card (id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CA9D86650F ON commentary (user_id_id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CA47706F91 ON commentary (card_id_id)');
        $this->addSql('ALTER TABLE deck ADD user_id_id INT NOT NULL, ADD game_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC36379D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC36374D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_4FAC36379D86650F ON deck (user_id_id)');
        $this->addSql('CREATE INDEX IDX_4FAC36374D77E7D8 ON deck (game_id_id)');
        $this->addSql('ALTER TABLE deck_card ADD card_id_id INT NOT NULL, ADD deck_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE deck_card ADD CONSTRAINT FK_2AF3DCED47706F91 FOREIGN KEY (card_id_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE deck_card ADD CONSTRAINT FK_2AF3DCEDBE1964B8 FOREIGN KEY (deck_id_id) REFERENCES deck (id)');
        $this->addSql('CREATE INDEX IDX_2AF3DCED47706F91 ON deck_card (card_id_id)');
        $this->addSql('CREATE INDEX IDX_2AF3DCEDBE1964B8 ON deck_card (deck_id_id)');
        $this->addSql('ALTER TABLE extension ADD game_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension ADD CONSTRAINT FK_9FB73D774D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_9FB73D774D77E7D8 ON extension (game_id_id)');
        $this->addSql('ALTER TABLE extension_collection ADD extension_id_id INT NOT NULL, ADD collect_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension_collection ADD CONSTRAINT FK_FB7D0BBCC00BA6B FOREIGN KEY (extension_id_id) REFERENCES extension (id)');
        $this->addSql('ALTER TABLE extension_collection ADD CONSTRAINT FK_FB7D0BB6397A789 FOREIGN KEY (collect_id_id) REFERENCES collect (id)');
        $this->addSql('CREATE INDEX IDX_FB7D0BBCC00BA6B ON extension_collection (extension_id_id)');
        $this->addSql('CREATE INDEX IDX_FB7D0BB6397A789 ON extension_collection (collect_id_id)');
        $this->addSql('ALTER TABLE message ADD user_sender_id_id INT NOT NULL, ADD user_recever_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE0AD8BCD FOREIGN KEY (user_sender_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F51A000E2 FOREIGN KEY (user_recever_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE0AD8BCD ON message (user_sender_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F51A000E2 ON message (user_recever_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collect DROP FOREIGN KEY FK_A40662F49D86650F');
        $this->addSql('ALTER TABLE collect DROP FOREIGN KEY FK_A40662F44D77E7D8');
        $this->addSql('DROP INDEX IDX_A40662F49D86650F ON collect');
        $this->addSql('DROP INDEX IDX_A40662F44D77E7D8 ON collect');
        $this->addSql('ALTER TABLE collect DROP user_id_id, DROP game_id_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE0AD8BCD');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F51A000E2');
        $this->addSql('DROP INDEX IDX_B6BD307FE0AD8BCD ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F51A000E2 ON message');
        $this->addSql('ALTER TABLE message DROP user_sender_id_id, DROP user_recever_id_id');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D34D77E7D8');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3CC00BA6B');
        $this->addSql('DROP INDEX IDX_161498D34D77E7D8 ON card');
        $this->addSql('DROP INDEX IDX_161498D3CC00BA6B ON card');
        $this->addSql('ALTER TABLE card DROP game_id_id, DROP extension_id_id');
        $this->addSql('ALTER TABLE card_collection DROP FOREIGN KEY FK_903FF83C47706F91');
        $this->addSql('ALTER TABLE card_collection DROP FOREIGN KEY FK_903FF83C6397A789');
        $this->addSql('DROP INDEX IDX_903FF83C47706F91 ON card_collection');
        $this->addSql('DROP INDEX IDX_903FF83C6397A789 ON card_collection');
        $this->addSql('ALTER TABLE card_collection DROP card_id_id, DROP collect_id_id');
        $this->addSql('ALTER TABLE deck_card DROP FOREIGN KEY FK_2AF3DCED47706F91');
        $this->addSql('ALTER TABLE deck_card DROP FOREIGN KEY FK_2AF3DCEDBE1964B8');
        $this->addSql('DROP INDEX IDX_2AF3DCED47706F91 ON deck_card');
        $this->addSql('DROP INDEX IDX_2AF3DCEDBE1964B8 ON deck_card');
        $this->addSql('ALTER TABLE deck_card DROP card_id_id, DROP deck_id_id');
        $this->addSql('ALTER TABLE extension DROP FOREIGN KEY FK_9FB73D774D77E7D8');
        $this->addSql('DROP INDEX IDX_9FB73D774D77E7D8 ON extension');
        $this->addSql('ALTER TABLE extension DROP game_id_id');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA9D86650F');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA47706F91');
        $this->addSql('DROP INDEX IDX_1CAC12CA9D86650F ON commentary');
        $this->addSql('DROP INDEX IDX_1CAC12CA47706F91 ON commentary');
        $this->addSql('ALTER TABLE commentary DROP user_id_id, DROP card_id_id');
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC36379D86650F');
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC36374D77E7D8');
        $this->addSql('DROP INDEX IDX_4FAC36379D86650F ON deck');
        $this->addSql('DROP INDEX IDX_4FAC36374D77E7D8 ON deck');
        $this->addSql('ALTER TABLE deck DROP user_id_id, DROP game_id_id');
        $this->addSql('ALTER TABLE extension_collection DROP FOREIGN KEY FK_FB7D0BBCC00BA6B');
        $this->addSql('ALTER TABLE extension_collection DROP FOREIGN KEY FK_FB7D0BB6397A789');
        $this->addSql('DROP INDEX IDX_FB7D0BBCC00BA6B ON extension_collection');
        $this->addSql('DROP INDEX IDX_FB7D0BB6397A789 ON extension_collection');
        $this->addSql('ALTER TABLE extension_collection DROP extension_id_id, DROP collect_id_id');
    }
}
