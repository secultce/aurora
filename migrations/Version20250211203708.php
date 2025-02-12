<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250211203708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create event_schedule table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event_schedule (id UUID NOT NULL, event_id UUID DEFAULT NULL, start_hour TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_hour TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_event_schedule_event_id ON event_schedule (event_id)');
        $this->addSql('COMMENT ON COLUMN event_schedule.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event_schedule.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE event_schedule ADD CONSTRAINT fk_event_schedule_event_event_id FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event_schedule DROP CONSTRAINT fk_event_schedule_event_event_id');
        $this->addSql('DROP TABLE event_schedule');
    }
}
