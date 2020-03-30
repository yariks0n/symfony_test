<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329090318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD account_to_id INT NOT NULL, ADD value DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16BA9314 FOREIGN KEY (account_to_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_723705D16BA9314 ON transaction (account_to_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16BA9314');
        $this->addSql('DROP INDEX IDX_723705D16BA9314 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP account_to_id, DROP value');
    }
}
