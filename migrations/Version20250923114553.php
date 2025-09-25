<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250923114553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497D2D4335');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DF88BA2F');
        $this->addSql('DROP INDEX UNIQ_8D93D649DF88BA2F ON user');
        $this->addSql('DROP INDEX IDX_8D93D6497D2D4335 ON user');
        $this->addSql('ALTER TABLE user ADD dossier_medical_id INT DEFAULT NULL, ADD groupe_sanguin_id INT DEFAULT NULL, DROP un_dossier_medical_id, DROP grp_sanguin_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B452768 FOREIGN KEY (groupe_sanguin_id) REFERENCES grp_sanguin (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497750B79F ON user (dossier_medical_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B452768 ON user (groupe_sanguin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497750B79F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B452768');
        $this->addSql('DROP INDEX UNIQ_8D93D6497750B79F ON user');
        $this->addSql('DROP INDEX IDX_8D93D649B452768 ON user');
        $this->addSql('ALTER TABLE user ADD un_dossier_medical_id INT DEFAULT NULL, ADD grp_sanguin_id INT DEFAULT NULL, DROP dossier_medical_id, DROP groupe_sanguin_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497D2D4335 FOREIGN KEY (grp_sanguin_id) REFERENCES grp_sanguin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DF88BA2F FOREIGN KEY (un_dossier_medical_id) REFERENCES dossier_medical (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649DF88BA2F ON user (un_dossier_medical_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497D2D4335 ON user (grp_sanguin_id)');
    }
}
