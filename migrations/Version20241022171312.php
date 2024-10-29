<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241022171312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the column extra_fields to event';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event ADD extra_fields JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event DROP COLUMN extra_fields');
    }
}
