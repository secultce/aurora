<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240826174829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the columns parent_id and created_by_id in space table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space ADD created_by_id UUID NOT NULL');
        $this->addSql('ALTER TABLE space ADD parent_id UUID DEFAULT NULL');

        $this->addSql('COMMENT ON COLUMN space.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN space.parent_id IS \'(DC2Type:uuid)\'');

        $this->addSql('ALTER TABLE space ADD CONSTRAINT fk_space_created_by_id_agent FOREIGN KEY (created_by_id) REFERENCES agent (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE space ADD CONSTRAINT fk_space_parent_id_space FOREIGN KEY (parent_id) REFERENCES space (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space DROP CONSTRAINT fk_space_created_by_id_agent');
        $this->addSql('ALTER TABLE space DROP CONSTRAINT fk_space_parent_id_space');

        $this->addSql('ALTER TABLE space DROP created_by_id');
        $this->addSql('ALTER TABLE space DROP parent_id');
    }
}
