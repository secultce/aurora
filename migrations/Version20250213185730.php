<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250213185730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create SpaceType Entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE space_type (id UUID NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN space_type.id IS \'(DC2Type:uuid)\'');

        $this->addSql('ALTER TABLE space ADD space_type_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN space.space_type_id IS \'(DC2Type:uuid)\'');

        $this->addSql('ALTER TABLE space ADD CONSTRAINT fk_space_space_type_id_space_type FOREIGN KEY (space_type_id) REFERENCES space_type (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2972C13A455857DB ON space (space_type_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space DROP CONSTRAINT fk_space_space_type_id_space_type');
        $this->addSql('DROP INDEX IDX_2972C13A455857DB');
        $this->addSql('ALTER TABLE space DROP COLUMN space_type_id');

        $this->addSql('DROP TABLE space_type');
    }
}
