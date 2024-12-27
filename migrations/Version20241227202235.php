<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241227202235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE space ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE agent ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE opportunity ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE organization ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "app_user" ALTER image TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE initiative ALTER image TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE space ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE agent ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE opportunity ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE organization ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE "app_user" ALTER image TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE initiative ALTER image TYPE VARCHAR(100)');
    }
}
