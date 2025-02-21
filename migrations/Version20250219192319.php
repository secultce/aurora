<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250219192319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new attributes in event entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE activity_area_events (event_id UUID NOT NULL, activity_area_id UUID NOT NULL, PRIMARY KEY(event_id, activity_area_id))');
        $this->addSql('CREATE INDEX idx_activity_area_events_event_id ON activity_area_events (event_id)');
        $this->addSql('CREATE INDEX idx_activity_area_events_activity_area_id ON activity_area_events (activity_area_id)');
        $this->addSql('COMMENT ON COLUMN activity_area_events.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN activity_area_events.activity_area_id IS \'(DC2Type:uuid)\'');

        $this->addSql('CREATE TABLE tag_events (event_id UUID NOT NULL, tag_id UUID NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX idx_tag_events_event_id ON tag_events (event_id)');
        $this->addSql('CREATE INDEX idx_tag_events_tag_id ON tag_events (tag_id)');
        $this->addSql('COMMENT ON COLUMN tag_events.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tag_events.tag_id IS \'(DC2Type:uuid)\'');

        $this->addSql('ALTER TABLE activity_area_events ADD CONSTRAINT fk_activity_area_events_event_event_id FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activity_area_events ADD CONSTRAINT fk_activity_area_events_activity_area_activity_area_id FOREIGN KEY (activity_area_id) REFERENCES activity_area (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER TABLE tag_events ADD CONSTRAINT fk_tag_events_event_event_id FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_events ADD CONSTRAINT fk_tag_events_tag_tag_id FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER TABLE event ADD cover_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD subtitle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD short_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD long_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD type SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD site VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD phone_number VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD max_capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD accessible_audio SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD accessible_libras SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD free BOOLEAN DEFAULT NULL');

        $this->addSql('UPDATE event SET type = 1 WHERE type IS NULL');
        $this->addSql('UPDATE event SET end_date = now() WHERE end_date IS NULL');
        $this->addSql('UPDATE event SET max_capacity = 100 WHERE max_capacity IS NULL');
        $this->addSql('UPDATE event SET accessible_audio = 3 WHERE accessible_audio IS NULL');
        $this->addSql('UPDATE event SET accessible_libras = 3 WHERE accessible_libras IS NULL');
        $this->addSql('UPDATE event SET free = true WHERE free IS NULL');

        $this->addSql('ALTER TABLE event ALTER type SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER end_date SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER max_capacity SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER accessible_audio SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER accessible_libras SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER free SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity_area_events DROP CONSTRAINT fk_activity_area_events_event_event_id');
        $this->addSql('ALTER TABLE activity_area_events DROP CONSTRAINT fk_activity_area_events_activity_area_activity_area_id');

        $this->addSql('ALTER TABLE tag_events DROP CONSTRAINT fk_tag_events_event_event_id');
        $this->addSql('ALTER TABLE tag_events DROP CONSTRAINT fk_tag_events_tag_tag_id');

        $this->addSql('DROP TABLE activity_area_events');
        $this->addSql('DROP TABLE tag_events');

        $this->addSql('ALTER TABLE event DROP cover_image');
        $this->addSql('ALTER TABLE event DROP subtitle');
        $this->addSql('ALTER TABLE event DROP short_description');
        $this->addSql('ALTER TABLE event DROP long_description');
        $this->addSql('ALTER TABLE event DROP type');
        $this->addSql('ALTER TABLE event DROP end_date');
        $this->addSql('ALTER TABLE event DROP site');
        $this->addSql('ALTER TABLE event DROP phone_number');
        $this->addSql('ALTER TABLE event DROP max_capacity');
        $this->addSql('ALTER TABLE event DROP accessible_audio');
        $this->addSql('ALTER TABLE event DROP accessible_libras');
        $this->addSql('ALTER TABLE event DROP free');
    }
}
