<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019210937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY cancion_FK');
        $this->addSql('ALTER TABLE cancion DROP lista_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion ADD lista_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT cancion_FK FOREIGN KEY (id) REFERENCES lista (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
