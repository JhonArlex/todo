<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109032543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D9A111542');
        $this->addSql('DROP INDEX IDX_2265B05D9A111542 ON usuario');
        $this->addSql('ALTER TABLE usuario DROP listas_id');
        $this->addSql('ALTER TABLE listas ADD usuario_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE listas ADD CONSTRAINT FK_C54ECE20629AF449 FOREIGN KEY (usuario_id_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_C54ECE20629AF449 ON listas (usuario_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas DROP FOREIGN KEY FK_C54ECE20629AF449');
        $this->addSql('DROP INDEX IDX_C54ECE20629AF449 ON listas');
        $this->addSql('ALTER TABLE listas DROP usuario_id_id');
        $this->addSql('ALTER TABLE usuario ADD listas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D9A111542 FOREIGN KEY (listas_id) REFERENCES listas (id)');
        $this->addSql('CREATE INDEX IDX_2265B05D9A111542 ON usuario (listas_id)');
    }
}
