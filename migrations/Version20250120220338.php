<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250120220338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create inscription_phase_review table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE inscription_phase_review (id UUID NOT NULL, inscription_phase_id UUID NOT NULL, reviewer_id UUID NOT NULL, result JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX UNIQ_41B01415309C6E2D ON inscription_phase_review (inscription_phase_id)');
        $this->addSql('CREATE INDEX UNIQ_41B0141570574616 ON inscription_phase_review (reviewer_id)');

        $this->addSql('COMMENT ON COLUMN inscription_phase_review.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase_review.inscription_phase_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase_review.reviewer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_phase_review.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE inscription_phase_review ADD CONSTRAINT fk_inscription_phase_review_inscription_phase_id_inscription_phase FOREIGN KEY (inscription_phase_id) REFERENCES inscription_phase (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription_phase_review ADD CONSTRAINT fk_inscription_phase_review_reviewer_id_agent FOREIGN KEY (reviewer_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inscription_phase_review DROP CONSTRAINT fk_inscription_phase_review_inscription_phase_id_inscription_phase');
        $this->addSql('ALTER TABLE inscription_phase_review DROP CONSTRAINT fk_inscription_phase_review_reviewer_id_agent');
        $this->addSql('DROP TABLE inscription_phase_review');
    }
}
