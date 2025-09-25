<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925124859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D19BF1BA4D60759 ON allergies (libelle)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE2E4F0DA4D60759 ON traitements (libelle)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D19BF1BA4D60759 ON allergies');
        $this->addSql('DROP INDEX UNIQ_BE2E4F0DA4D60759 ON traitements');
    }
}
