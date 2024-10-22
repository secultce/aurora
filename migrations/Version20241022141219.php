<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241022141219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the relation between user and agent';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent ADD user_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN agent.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT fk_agent_user_id_app_user FOREIGN KEY (user_id) REFERENCES "app_user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_268B9C9DA76ED395 ON agent (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT fk_agent_user_id_app_user');
        $this->addSql('DROP INDEX IDX_268B9C9DA76ED395');
        $this->addSql('ALTER TABLE agent DROP user_id');
    }
}
