<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241024012312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the field image to opportunity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE opportunity ADD image VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE opportunity DROP image');
    }
}
