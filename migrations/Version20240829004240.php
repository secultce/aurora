<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240829004240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes the opportunity table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE opportunity (
                id UUID NOT NULL,
                name VARCHAR(100) NOT NULL,
                parent_id UUID DEFAULT NULL,
                space_id UUID DEFAULT NULL,
                initiative_id UUID DEFAULT NULL,
                event_id UUID DEFAULT NULL,
                created_by UUID NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN opportunity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.initiative_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN opportunity.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_opportunity_parent_id_opportunity FOREIGN KEY (parent_id) REFERENCES opportunity (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_opportunity_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_opportunity_initiative_id_initiative FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_opportunity_event_id_event FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_opportunity_created_by_id_agent FOREIGN KEY (created_by) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_parent_id_opportunity');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_space_id_space');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_initiative_id_initiative');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_event_id_event');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_created_by_id_agent');

        $this->addSql('DROP TABLE opportunity');
    }
}
