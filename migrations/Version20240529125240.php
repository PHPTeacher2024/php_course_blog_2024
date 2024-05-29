<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240529125240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image path column';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `post`
            ADD `image_path` VARCHAR(200) DEFAULT NULL AFTER `content`
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `post`
            DROP COLUMN `image_path`
        SQL);
    }
}
