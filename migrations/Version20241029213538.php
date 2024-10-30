<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241029213538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the phase table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE phase (id UUID NOT NULL, created_by_id UUID NOT NULL, opportunity_id UUID NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status BOOLEAN NOT NULL, sequence INT DEFAULT NULL, extra_fields JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B1BDD6CBB03A8386 ON phase (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B1BDD6CB9A34590F ON phase (opportunity_id)');
        $this->addSql('COMMENT ON COLUMN phase.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN phase.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN phase.opportunity_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN phase.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT fk_phase_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT fk_phase_opportunity_id_opportunity FOREIGN KEY (opportunity_id) REFERENCES opportunity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE phase DROP CONSTRAINT fk_phase_created_by_id_agent');
        $this->addSql('ALTER TABLE phase DROP CONSTRAINT fk_phase_opportunity_id_opportunity');
        $this->addSql('DROP TABLE phase');
    }
}
