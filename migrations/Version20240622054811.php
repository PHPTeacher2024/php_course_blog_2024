<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622054811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE user
(
    id INT UNSIGNED AUTO_INCREMENT,
    email VARCHAR(200),
    first_name VARCHAR(200),
    last_name VARCHAR(200),
    password VARCHAR(200),
    role INT UNSIGNED,
    image_id INT UNSIGNED DEFAULT NULL,
    UNIQUE KEY `email` (`email`),
    PRIMARY KEY (id)
)
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE user");
    }
}
