<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250131015424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create ActivityArea entity and its relation with Space';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE activity_area (id UUID NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE activity_area_spaces (activity_area_id UUID NOT NULL, space_id UUID NOT NULL, PRIMARY KEY(activity_area_id, space_id))');

        $this->addSql('CREATE INDEX IDX_F15AB7E8BD5D367C ON activity_area_spaces (activity_area_id)');
        $this->addSql('CREATE INDEX IDX_F15AB7E823575340 ON activity_area_spaces (space_id)');

        $this->addSql('ALTER TABLE activity_area_spaces ADD CONSTRAINT fk_activity_area_spaces_by_activity_area_id FOREIGN KEY (activity_area_id) REFERENCES activity_area (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_area_spaces ADD CONSTRAINT fk_activity_area_spaces_by_space_id FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE activity_area_spaces');
        $this->addSql('DROP TABLE activity_area');
    }
}
