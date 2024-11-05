<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241104143439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create tables city and state';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE city (id UUID NOT NULL, state_id UUID DEFAULT NULL, name VARCHAR(100) NOT NULL, city_code INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D5B02345D83CC1 ON city (state_id)');
        $this->addSql('COMMENT ON COLUMN city.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN city.state_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE state (id UUID NOT NULL, capital_id UUID DEFAULT NULL, name VARCHAR(100) NOT NULL, acronym VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A393D2FBFC2D9FF7 ON state (capital_id)');
        $this->addSql('COMMENT ON COLUMN state.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN state.capital_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02345D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FBFC2D9FF7 FOREIGN KEY (capital_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B02345D83CC1');
        $this->addSql('ALTER TABLE state DROP CONSTRAINT FK_A393D2FBFC2D9FF7');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE state');
    }
}
