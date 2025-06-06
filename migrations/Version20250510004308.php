<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510004308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Check if the column 'status' exists before adding it
        $schemaManager = $this->connection->createSchemaManager();
        $columns = $schemaManager->listTableColumns('paiement');

        if (!array_key_exists('status', $columns)) {
            $this->addSql("ALTER TABLE paiement ADD status VARCHAR(255) DEFAULT NULL");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE paiement DROP status
        SQL);
    }
}
