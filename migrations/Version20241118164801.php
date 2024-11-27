<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241118164801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes faq tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE faq (
                id UUID NOT NULL,
                question VARCHAR(255) NOT NULL,
                answer VARCHAR(255) NOT NULL,
                active  BOOLEAN NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('COMMENT ON COLUMN faq.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN faq.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE faq');
    }
}
