<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241203023914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create seal and seal_entity table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE seal (id UUID NOT NULL, created_by_id UUID NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, expiration_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E30AE30B03A8386 ON seal (created_by_id)');
        $this->addSql('COMMENT ON COLUMN seal.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN seal.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN seal.expiration_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN seal.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('CREATE TABLE seal_entity (id UUID NOT NULL, created_by_id UUID NOT NULL, entity_id UUID NOT NULL, entity SMALLINT NOT NULL, authorized_by SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DA216ACB03A8386 ON seal_entity (created_by_id)');
        $this->addSql('COMMENT ON COLUMN seal_entity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN seal_entity.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN seal_entity.entity_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN seal_entity.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('ALTER TABLE seal ADD CONSTRAINT fk_seal_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seal_entity ADD CONSTRAINT fk_seal_entity_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE seal');
        $this->addSql('DROP TABLE seal_entity');

        $this->addSql('ALTER TABLE seal DROP CONSTRAINT fk_seal_created_by_id_agent');
        $this->addSql('ALTER TABLE seal_entity DROP CONSTRAINT fk_seal_entity_created_by_id_agent');
    }
}
