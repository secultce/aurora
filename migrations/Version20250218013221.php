<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250218013221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create ArchitecturalAccessibility entity and its relation with Space';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE architectural_accessibility (id UUID NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE spaces_accessibilities (space_id UUID NOT NULL, architectural_accessibility_id UUID NOT NULL, PRIMARY KEY(space_id, architectural_accessibility_id))');

        $this->addSql('CREATE INDEX IDX_3A28D51523575340 ON spaces_accessibilities (space_id)');
        $this->addSql('CREATE INDEX IDX_3A28D515FB50A7E ON spaces_accessibilities (architectural_accessibility_id)');

        $this->addSql('ALTER TABLE spaces_accessibilities ADD CONSTRAINT fk_space_accessibilities_by_space_id FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE spaces_accessibilities ADD CONSTRAINT fk_space_accessibilities_by_architectural_accessibility_id FOREIGN KEY (architectural_accessibility_id) REFERENCES architectural_accessibility (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE architectural_accessibility');
        $this->addSql('DROP TABLE spaces_accessibilities');
    }
}
