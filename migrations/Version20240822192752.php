<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822192752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes agent, space project tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE agent (
                id UUID NOT NULL, 
                name VARCHAR(100) NOT NULL, 
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN agent.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN agent.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('
            CREATE TABLE project (
                id UUID NOT NULL, 
                name VARCHAR(100) NOT NULL,
                created_by_id UUID NOT NULL,
                parent_id UUID DEFAULT NULL,
                space_id UUID DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN project.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN project.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN project.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN project.space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN project.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('
            CREATE TABLE space (
                id UUID NOT NULL, 
                name VARCHAR(100) NOT NULL, 
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN space.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_project_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_project_parent_id_project FOREIGN KEY (parent_id) REFERENCES project (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_project_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_project_created_by_agent');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_project_parent_id_project');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_project_space_id_space');

        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE space');
    }
}
