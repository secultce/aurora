<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250203134040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create join table space_tags';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE space_tags (space_id UUID NOT NULL, tag_id UUID NOT NULL, PRIMARY KEY(space_id, tag_id))');

        $this->addSql('CREATE INDEX IDX_SPACE_TAGS_SPACE_ID ON space_tags (space_id)');
        $this->addSql('CREATE INDEX IDX_SPACE_TAGS_TAG_ID ON space_tags (tag_id)');

        $this->addSql('ALTER TABLE space_tags ADD CONSTRAINT FK_SPACE_TAGS_SPACE FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE space_tags ADD CONSTRAINT FK_SPACE_TAGS_TAG FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE space_tags');
    }
}
