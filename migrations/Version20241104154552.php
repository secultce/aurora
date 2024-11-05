<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241104154552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'populate tables city and state';
    }

    public function up(Schema $schema): void
    {
        $sqlStates = file_get_contents(__DIR__.'/raw/Version20241104154552-populate-states.sql');
        $this->addSql($sqlStates);
        $sqlCities = file_get_contents(__DIR__.'/raw/Version20241104154552-populate-cities.sql');
        $this->addSql($sqlCities);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE city CASCADE');
        $this->addSql('TRUNCATE state CASCADE');
    }
}
