<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922202750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64937D184CC ON user (num_telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64949136D9C ON user (num_secu)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64937D184CC ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D64949136D9C ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
