<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250923122554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier_medical_allergies (dossier_medical_id INT NOT NULL, allergies_id INT NOT NULL, INDEX IDX_82A99F837750B79F (dossier_medical_id), INDEX IDX_82A99F837104939B (allergies_id), PRIMARY KEY(dossier_medical_id, allergies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier_medical_traitements (dossier_medical_id INT NOT NULL, traitements_id INT NOT NULL, INDEX IDX_3CD860677750B79F (dossier_medical_id), INDEX IDX_3CD86067C5AE08D8 (traitements_id), PRIMARY KEY(dossier_medical_id, traitements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossier_medical_allergies ADD CONSTRAINT FK_82A99F837750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier_medical_allergies ADD CONSTRAINT FK_82A99F837104939B FOREIGN KEY (allergies_id) REFERENCES allergies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier_medical_traitements ADD CONSTRAINT FK_3CD860677750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier_medical_traitements ADD CONSTRAINT FK_3CD86067C5AE08D8 FOREIGN KEY (traitements_id) REFERENCES traitements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier_medical ADD groupe_sanguin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE62B452768 FOREIGN KEY (groupe_sanguin_id) REFERENCES grp_sanguin (id)');
        $this->addSql('CREATE INDEX IDX_3581EE62B452768 ON dossier_medical (groupe_sanguin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical_allergies DROP FOREIGN KEY FK_82A99F837750B79F');
        $this->addSql('ALTER TABLE dossier_medical_allergies DROP FOREIGN KEY FK_82A99F837104939B');
        $this->addSql('ALTER TABLE dossier_medical_traitements DROP FOREIGN KEY FK_3CD860677750B79F');
        $this->addSql('ALTER TABLE dossier_medical_traitements DROP FOREIGN KEY FK_3CD86067C5AE08D8');
        $this->addSql('DROP TABLE dossier_medical_allergies');
        $this->addSql('DROP TABLE dossier_medical_traitements');
        $this->addSql('ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE62B452768');
        $this->addSql('DROP INDEX IDX_3581EE62B452768 ON dossier_medical');
        $this->addSql('ALTER TABLE dossier_medical DROP groupe_sanguin_id');
    }
}
