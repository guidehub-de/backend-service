<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414163903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD confirmation_hash VARCHAR(255) DEFAULT NULL, ADD confirmed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', ADD is_confirmed TINYINT(1) NOT NULL, ADD locale VARCHAR(5) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP created_at, DROP updated_at, DROP confirmation_hash, DROP confirmed_at, DROP is_confirmed, DROP locale
        SQL);
    }
}
