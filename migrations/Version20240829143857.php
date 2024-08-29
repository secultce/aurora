<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240829143857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates/Drops organization table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE organization (
            id UUID NOT NULL, 
            owner_id UUID NOT NULL, 
            created_by UUID NOT NULL, 
            name VARCHAR(100) NOT NULL, 
            description VARCHAR(255) DEFAULT NULL, 
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
            deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_C1EE637C7E3C61F9 ON organization (owner_id)');
        $this->addSql('CREATE INDEX IDX_C1EE637CDE12AB56 ON organization (created_by)');
        $this->addSql('COMMENT ON COLUMN organization.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN organization.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN organization.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN organization.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE organizations_agents (
            organization_id UUID NOT NULL, 
            agent_id UUID NOT NULL, 
            PRIMARY KEY(organization_id, agent_id)
        )');
        $this->addSql('CREATE INDEX IDX_FAEB3B732C8A3DE ON organizations_agents (organization_id)');
        $this->addSql('CREATE INDEX IDX_FAEB3B73414710B ON organizations_agents (agent_id)');
        $this->addSql('COMMENT ON COLUMN organizations_agents.organization_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN organizations_agents.agent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT fk_organization_owner_id_agent FOREIGN KEY (owner_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT fk_organization_agent_id_agent FOREIGN KEY (created_by) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organizations_agents ADD CONSTRAINT fk_organizations_agents_organization_id_organization FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organizations_agents ADD CONSTRAINT fk_organizations_agents_agent_id_agent FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT fk_organization_owner_id_agent');
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT fk_organization_agent_id_agent');
        $this->addSql('ALTER TABLE organizations_agents DROP CONSTRAINT fk_organizations_agents_organization_id_organization');
        $this->addSql('ALTER TABLE organizations_agents DROP CONSTRAINT fk_organizations_agents_agent_id_agent');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organizations_agents');
    }
}
