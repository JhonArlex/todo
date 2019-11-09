<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109044330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tareas DROP tarea_id, DROP tarea_padre, CHANGE lista_id lista_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tareas ADD CONSTRAINT FK_BFE3AB356736D68F FOREIGN KEY (lista_id) REFERENCES listas (id)');
        $this->addSql('CREATE INDEX IDX_BFE3AB356736D68F ON tareas (lista_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tareas DROP FOREIGN KEY FK_BFE3AB356736D68F');
        $this->addSql('DROP INDEX IDX_BFE3AB356736D68F ON tareas');
        $this->addSql('ALTER TABLE tareas ADD tarea_id INT NOT NULL, ADD tarea_padre INT NOT NULL, CHANGE lista_id lista_id INT NOT NULL');
    }
}
