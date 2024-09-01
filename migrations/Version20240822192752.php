<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822192752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes agent, space initiative tables';
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
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN space.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_parent_id_initiative FOREIGN KEY (parent_id) REFERENCES initiative (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE initiative ADD CONSTRAINT fk_initiative_space_id_space FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_created_by_agent');
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_parent_id_initiative');
        $this->addSql('ALTER TABLE initiative DROP CONSTRAINT fk_initiative_space_id_space');

        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE initiative');
        $this->addSql('DROP TABLE space');
    }
}
