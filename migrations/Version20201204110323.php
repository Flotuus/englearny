<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204110323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mot_liste (mot_id INT NOT NULL, liste_id INT NOT NULL, INDEX IDX_9DC153B963977652 (mot_id), INDEX IDX_9DC153B9E85441D8 (liste_id), PRIMARY KEY(mot_id, liste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realise_test (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, utilisateur_id INT NOT NULL, realise_aujourd_hui TINYINT(1) NOT NULL, score INT DEFAULT NULL, INDEX IDX_1F30E8451E5D0459 (test_id), INDEX IDX_1F30E845FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B963977652 FOREIGN KEY (mot_id) REFERENCES mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B9E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realise_test ADD CONSTRAINT FK_1F30E8451E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE realise_test ADD CONSTRAINT FK_1F30E845FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE liste ADD entreprise_id INT DEFAULT NULL, ADD theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF459027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_FCF22AF4A4AEAFEA ON liste (entreprise_id)');
        $this->addSql('CREATE INDEX IDX_FCF22AF459027487 ON liste (theme_id)');
        $this->addSql('ALTER TABLE mot ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE mot ADD CONSTRAINT FK_A43432CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_A43432CBCF5E72D ON mot (categorie_id)');
        $this->addSql('ALTER TABLE test ADD theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C59027487 ON test (theme_id)');
        $this->addSql('ALTER TABLE utilisateur ADD role_id INT NOT NULL, ADD abonnement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D60322AC ON utilisateur (role_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3F1D74413 ON utilisateur (abonnement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mot_liste');
        $this->addSql('DROP TABLE realise_test');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4A4AEAFEA');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF459027487');
        $this->addSql('DROP INDEX IDX_FCF22AF4A4AEAFEA ON liste');
        $this->addSql('DROP INDEX IDX_FCF22AF459027487 ON liste');
        $this->addSql('ALTER TABLE liste DROP entreprise_id, DROP theme_id');
        $this->addSql('ALTER TABLE mot DROP FOREIGN KEY FK_A43432CBCF5E72D');
        $this->addSql('DROP INDEX IDX_A43432CBCF5E72D ON mot');
        $this->addSql('ALTER TABLE mot DROP categorie_id');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C59027487');
        $this->addSql('DROP INDEX IDX_D87F7E0C59027487 ON test');
        $this->addSql('ALTER TABLE test DROP theme_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3F1D74413');
        $this->addSql('DROP INDEX IDX_1D1C63B3D60322AC ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3F1D74413 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP role_id, DROP abonnement_id');
    }
}
