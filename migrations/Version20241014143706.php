<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241014143706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the image field to the user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE app_user ADD image VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE app_user DROP COLUMN image');
    }
}
