<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241019194919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the field extra_fields to opportunity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE opportunity ADD extra_fields JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE opportunity DROP extra_fields');
    }
}
