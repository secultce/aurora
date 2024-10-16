<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241015164203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the field extra_fields to agent';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent ADD extra_fields JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP extra_fields');
    }
}
