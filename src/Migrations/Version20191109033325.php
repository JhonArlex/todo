<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109033325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas DROP FOREIGN KEY FK_C54ECE20629AF449');
        $this->addSql('DROP INDEX IDX_C54ECE20629AF449 ON listas');
        $this->addSql('ALTER TABLE listas ADD usuario_id INT DEFAULT NULL, DROP usuario_id_id');
        $this->addSql('ALTER TABLE listas ADD CONSTRAINT FK_C54ECE20DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_C54ECE20DB38439E ON listas (usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas DROP FOREIGN KEY FK_C54ECE20DB38439E');
        $this->addSql('DROP INDEX IDX_C54ECE20DB38439E ON listas');
        $this->addSql('ALTER TABLE listas ADD usuario_id_id INT DEFAULT NULL, DROP usuario_id');
        $this->addSql('ALTER TABLE listas ADD CONSTRAINT FK_C54ECE20629AF449 FOREIGN KEY (usuario_id_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_C54ECE20629AF449 ON listas (usuario_id_id)');
    }
}
