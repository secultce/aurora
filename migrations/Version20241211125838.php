<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241211125838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the image field to the event';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event ADD image VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event DROP COLUMN image');
    }
}
