<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109032117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usuario ADD listas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D9A111542 FOREIGN KEY (listas_id) REFERENCES listas (id)');
        $this->addSql('CREATE INDEX IDX_2265B05D9A111542 ON usuario (listas_id)');
        $this->addSql('ALTER TABLE listas DROP lista_id, DROP usuario_id, DROP nota, DROP tarea_padre, DROP importante, DROP estado, CHANGE fechas_creacion fecha_creacion DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listas ADD lista_id INT NOT NULL, ADD usuario_id INT NOT NULL, ADD nota LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, ADD tarea_padre INT NOT NULL, ADD importante TINYINT(1) NOT NULL, ADD estado VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE fecha_creacion fechas_creacion DATETIME NOT NULL');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D9A111542');
        $this->addSql('DROP INDEX IDX_2265B05D9A111542 ON usuario');
        $this->addSql('ALTER TABLE usuario DROP listas_id');
    }
}
