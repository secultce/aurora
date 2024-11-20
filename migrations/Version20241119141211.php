<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241119141211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes column main on agent table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE agent ADD COLUMN main BOOLEAN DEFAULT FALSE
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP COLUMN main');
    }
}
