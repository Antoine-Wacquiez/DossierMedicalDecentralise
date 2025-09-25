<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924071534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_traitements DROP FOREIGN KEY FK_17358698A76ED395');
        $this->addSql('ALTER TABLE user_traitements DROP FOREIGN KEY FK_17358698C5AE08D8');
        $this->addSql('ALTER TABLE user_allergies DROP FOREIGN KEY FK_8DF932FF7104939B');
        $this->addSql('ALTER TABLE user_allergies DROP FOREIGN KEY FK_8DF932FFA76ED395');
        $this->addSql('DROP TABLE user_traitements');
        $this->addSql('DROP TABLE user_allergies');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B452768');
        $this->addSql('DROP INDEX IDX_8D93D649B452768 ON user');
        $this->addSql('ALTER TABLE user DROP groupe_sanguin_id, CHANGE num_telephone num_telephone VARCHAR(15) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_traitements (user_id INT NOT NULL, traitements_id INT NOT NULL, INDEX IDX_17358698A76ED395 (user_id), INDEX IDX_17358698C5AE08D8 (traitements_id), PRIMARY KEY(user_id, traitements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_allergies (user_id INT NOT NULL, allergies_id INT NOT NULL, INDEX IDX_8DF932FFA76ED395 (user_id), INDEX IDX_8DF932FF7104939B (allergies_id), PRIMARY KEY(user_id, allergies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_traitements ADD CONSTRAINT FK_17358698A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_traitements ADD CONSTRAINT FK_17358698C5AE08D8 FOREIGN KEY (traitements_id) REFERENCES traitements (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT FK_8DF932FF7104939B FOREIGN KEY (allergies_id) REFERENCES allergies (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergies ADD CONSTRAINT FK_8DF932FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD groupe_sanguin_id INT DEFAULT NULL, CHANGE num_telephone num_telephone VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B452768 FOREIGN KEY (groupe_sanguin_id) REFERENCES grp_sanguin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649B452768 ON user (groupe_sanguin_id)');
    }
}
