<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250122112642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add reviewers and criteria to phase table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE phase ADD COLUMN criteria JSON NOT NULL');

        $this->addSql('CREATE TABLE phase_reviewers (phase_id UUID NOT NULL, agent_id UUID NOT NULL, PRIMARY KEY(phase_id, agent_id))');

        $this->addSql('CREATE INDEX IDX_PHASE_REVIEWERS_PHASE_ID ON phase_reviewers (phase_id)');
        $this->addSql('CREATE INDEX IDX_PHASE_REVIEWERS_AGENT_ID ON phase_reviewers (agent_id)');

        $this->addSql('ALTER TABLE phase_reviewers ADD CONSTRAINT FK_PHASE_REVIEWERS_PHASE FOREIGN KEY (phase_id) REFERENCES phase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE phase_reviewers ADD CONSTRAINT FK_PHASE_REVIEWERS_AGENT FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE phase DROP COLUMN criteria');
        $this->addSql('DROP TABLE phase_reviewers');
    }
}
