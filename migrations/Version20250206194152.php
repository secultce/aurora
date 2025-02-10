<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250206194152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the table event activity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event_activity (id UUID NOT NULL, event_id UUID NOT NULL, title VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event_activity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_activity.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE INDEX IDX_EA98E08A71F7E88B ON event_activity (event_id)');
        $this->addSql('ALTER TABLE event_activity ADD CONSTRAINT fk_event_activity_event_id_event FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_activity DROP CONSTRAINT fk_event_activity_event_id_event');
        $this->addSql('DROP TABLE event_activity');
    }
}
