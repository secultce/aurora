<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240819123854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds/Removes app_user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE app_user (
                id UUID NOT NULL, 
                firstname VARCHAR(50) NOT NULL, 
                lastname VARCHAR(50) NOT NULL, 
                social_name VARCHAR(100) DEFAULT NULL, 
                email VARCHAR(100) NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT NOW(), 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('COMMENT ON COLUMN "app_user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "app_user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "app_user".updated_at IS \'(DC2Type:datetime_mutable)\'');
        $this->addSql('COMMENT ON COLUMN "app_user".deleted_at IS \'(DC2Type:datetime_mutable)\'');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON app_user (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE app_user');
    }
}
