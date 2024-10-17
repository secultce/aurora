<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241017021959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the field extra_fields to initiative';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE initiative ADD extra_fields JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE initiative DROP extra_fields');
    }
}
