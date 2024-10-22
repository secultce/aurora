<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241018125752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add extra_fields column in organization table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE organization ADD extra_fields JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE organization DROP COLUMN extra_fields');
    }
}
