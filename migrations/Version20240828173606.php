<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240828173606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add/Remove the columns short_bio, long_bio and culture in agent table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent ADD short_bio VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE agent ADD long_bio VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE agent ADD culture BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP short_bio');
        $this->addSql('ALTER TABLE agent DROP long_bio');
        $this->addSql('ALTER TABLE agent DROP culture');
    }
}
