<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241206144621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create inscription_phase table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE inscription_phase (id UUID NOT NULL, agent_id UUID NOT NULL, phase_id UUID NOT NULL, status SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E3F482863414710B ON inscription_phase (agent_id)');
        $this->addSql('CREATE INDEX IDX_E3F4828699091188 ON inscription_phase (phase_id)');

        $this->addSql('COMMENT ON COLUMN inscription_phase.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase.agent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase.phase_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE inscription_phase ADD CONSTRAINT fk_inscription_phase_agent_id_agent FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription_phase ADD CONSTRAINT fk_inscription_phase_phase_id_phase FOREIGN KEY (phase_id) REFERENCES phase (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER INDEX idx_5e90f6d63414710b RENAME TO IDX_74F85E073414710B');
        $this->addSql('ALTER INDEX idx_5e90f6d69a34590f RENAME TO IDX_74F85E079A34590F');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inscription_phase DROP CONSTRAINT fk_inscription_phase_agent_id_agent');
        $this->addSql('ALTER TABLE inscription_phase DROP CONSTRAINT fk_inscription_phase_phase_id_phase');
        $this->addSql('DROP TABLE inscription_phase');
    }
}
