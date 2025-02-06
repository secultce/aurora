<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250203133356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table tag';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tag (id UUID NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id))');

        $this->addSql('COMMENT ON COLUMN tag.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tag');
    }
}
