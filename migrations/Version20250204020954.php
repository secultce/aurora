<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250204020954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new attributes to Space entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space ADD short_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD long_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD cover_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD site VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD phone_number VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD max_capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE space ADD is_accessible BOOLEAN DEFAULT NULL');
        $this->addSql('UPDATE space SET is_accessible = true');
        $this->addSql('UPDATE space SET max_capacity = 100');
        $this->addSql('ALTER TABLE space ALTER is_accessible SET NOT NULL');
        $this->addSql('ALTER TABLE space ALTER max_capacity SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space DROP short_description');
        $this->addSql('ALTER TABLE space DROP long_description');
        $this->addSql('ALTER TABLE space DROP cover_image');
        $this->addSql('ALTER TABLE space DROP site');
        $this->addSql('ALTER TABLE space DROP email');
        $this->addSql('ALTER TABLE space DROP phone_number');
        $this->addSql('ALTER TABLE space DROP max_capacity');
        $this->addSql('ALTER TABLE space DROP is_accessible');
    }
}
