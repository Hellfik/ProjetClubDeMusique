<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814145245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conseil_admin ADD photos VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE instruments ADD CONSTRAINT FK_E350DE0B3D95329 FOREIGN KEY (famille_instruments_id) REFERENCES famille_instruments (id)');
        $this->addSql('ALTER TABLE musiciens ADD photos VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conseil_admin DROP photos');
        $this->addSql('ALTER TABLE instruments DROP FOREIGN KEY FK_E350DE0B3D95329');
        $this->addSql('ALTER TABLE musiciens DROP photos');
    }
}
