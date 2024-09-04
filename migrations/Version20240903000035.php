<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240903000035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes agent, space, initiative, event, opportunity, organization tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE app_user (
                id UUID NOT NULL,
                firstname VARCHAR(50) NOT NULL,
                lastname VARCHAR(50) NOT NULL,
                social_name VARCHAR(100) DEFAULT NULL,
                email VARCHAR(100) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('COMMENT ON COLUMN app_user.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');

        $this->addSql('
            CREATE TABLE agent (
                id UUID NOT NULL,
                name VARCHAR(100) NOT NULL,
                short_bio VARCHAR(100) NOT NULL,
                long_bio VARCHAR(255) NOT NULL,
                culture BOOLEAN NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('COMMENT ON COLUMN agent.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN agent.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('
            CREATE TABLE initiative (
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
        $this->addSql('COMMENT ON COLUMN initiative.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN initiative.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN initiative.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN initiative.space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN initiative.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('
            CREATE TABLE space (
                id UUID NOT NULL,
                name VARCHAR(100) NOT NULL,
                created_by_id UUID NOT NULL,
                parent_id UUID DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('COMMENT ON COLUMN space.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_parent_id_initiative FOREIGN KEY (parent_id) REFERENCES initiative (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE space ADD CONSTRAINT fk_space_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE space ADD CONSTRAINT fk_space_parent_id_space FOREIGN KEY (parent_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('
            CREATE TABLE event (
                id UUID NOT NULL,
                agent_group_id UUID DEFAULT NULL,
                space_id UUID DEFAULT NULL,
                initiative_id UUID DEFAULT NULL,
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
        $this->addSql('COMMENT ON COLUMN event.initiative_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_agent_group_id_agent FOREIGN KEY (agent_group_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_initiative_id_initiative FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_parent_id_event FOREIGN KEY (parent_id) REFERENCES event (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

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
        $this->addSql('ALTER TABLE organizations_agents DROP CONSTRAINT fk_organizations_agents_organization_id_organization');
        $this->addSql('ALTER TABLE organizations_agents DROP CONSTRAINT fk_organizations_agents_agent_id_agent');
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT fk_organization_owner_id_agent');
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT fk_organization_agent_id_agent');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_parent_id_opportunity');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_space_id_space');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_initiative_id_initiative');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_event_id_event');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_opportunity_created_by_id_agent');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_agent_group_id_agent');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_space_id_space');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_initiative_id_initiative');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_parent_id_event');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_event_created_by_id_agent');
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_created_by_id_agent');
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_parent_id_initiative');
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_space_id_space');
        $this->addSql('ALTER TABLE space DROP CONSTRAINT fk_space_created_by_id_agent');
        $this->addSql('ALTER TABLE space DROP CONSTRAINT fk_space_parent_id_space');

        $this->addSql('DROP TABLE organizations_agents');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE opportunity');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE initiative');
        $this->addSql('DROP TABLE space');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE "app_user"');
    }
}
