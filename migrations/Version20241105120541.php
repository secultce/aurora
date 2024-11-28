<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241105120541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the inscription_opportunity table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE inscription_opportunity (id UUID NOT NULL, agent_id UUID NOT NULL, opportunity_id UUID NOT NULL, status SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D63414710B ON inscription_opportunity (agent_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D69A34590F ON inscription_opportunity (opportunity_id)');
        $this->addSql('COMMENT ON COLUMN inscription_opportunity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_opportunity.agent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_opportunity.opportunity_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inscription_opportunity.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE inscription_opportunity ADD CONSTRAINT fk_inscription_opportunity_agent_id_agent FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription_opportunity ADD CONSTRAINT fk_inscription_opportunity_opportunity_id_opportunity FOREIGN KEY (opportunity_id) REFERENCES opportunity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER TABLE inscription_opportunity ADD CONSTRAINT unique_agent_opportunity UNIQUE (agent_id, opportunity_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inscription_opportunity DROP CONSTRAINT unique_agent_opportunity');
        $this->addSql('ALTER TABLE inscription_opportunity DROP CONSTRAINT fk_inscription_opportunity_agent_id_agent');
        $this->addSql('ALTER TABLE inscription_opportunity DROP CONSTRAINT fk_inscription_opportunity_opportunity_id_opportunity');
        $this->addSql('DROP TABLE inscription_opportunity');
    }
}
