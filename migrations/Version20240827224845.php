<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240827224845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes the event table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE event (
                id UUID NOT NULL, 
                agent_group_id UUID DEFAULT NULL, 
                space_id UUID DEFAULT NULL, 
                project_id UUID DEFAULT NULL, 
                parent_id UUID DEFAULT NULL, 
                created_by_id UUID NOT NULL, 
                name VARCHAR(100) NOT NULL, 
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.agent_group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.project_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_agent_group_id_agent FOREIGN KEY (agent_group_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_project_id_project FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_parent_id_event FOREIGN KEY (parent_id) REFERENCES event (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_agent_group_id_agent');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_space_id_space');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_project_id_project');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_parent_id_event');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_created_by_id_agent');

        $this->addSql('DROP TABLE event');
    }
}
