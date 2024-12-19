<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241218162813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the constraint unique between two columns in the table inscription_phase';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inscription_phase ADD CONSTRAINT unique_agent_phase UNIQUE (agent_id, phase_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inscription_phase DROP CONSTRAINT unique_agent_phase');
    }
}
