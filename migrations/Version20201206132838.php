<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206132838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, paiementunefois TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, theme_id INT DEFAULT NULL, libelle VARCHAR(100) NOT NULL, INDEX IDX_FCF22AF4A4AEAFEA (entreprise_id), INDEX IDX_FCF22AF459027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mot (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, libelle VARCHAR(100) NOT NULL, INDEX IDX_A43432CBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mot_liste (mot_id INT NOT NULL, liste_id INT NOT NULL, INDEX IDX_9DC153B963977652 (mot_id), INDEX IDX_9DC153B9E85441D8 (liste_id), PRIMARY KEY(mot_id, liste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realise_test (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, utilisateur_id INT NOT NULL, realise_aujourd_hui TINYINT(1) NOT NULL, score INT DEFAULT NULL, INDEX IDX_1F30E8451E5D0459 (test_id), INDEX IDX_1F30E845FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, libelle VARCHAR(100) NOT NULL, niveau INT NOT NULL, INDEX IDX_D87F7E0C59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, abonnement_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(100) NOT NULL, INDEX IDX_1D1C63B3D60322AC (role_id), INDEX IDX_1D1C63B3F1D74413 (abonnement_id), INDEX IDX_1D1C63B3A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF459027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE mot ADD CONSTRAINT FK_A43432CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B963977652 FOREIGN KEY (mot_id) REFERENCES mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B9E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realise_test ADD CONSTRAINT FK_1F30E8451E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE realise_test ADD CONSTRAINT FK_1F30E845FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3F1D74413');
        $this->addSql('ALTER TABLE mot DROP FOREIGN KEY FK_A43432CBCF5E72D');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4A4AEAFEA');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A4AEAFEA');
        $this->addSql('ALTER TABLE mot_liste DROP FOREIGN KEY FK_9DC153B9E85441D8');
        $this->addSql('ALTER TABLE mot_liste DROP FOREIGN KEY FK_9DC153B963977652');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE realise_test DROP FOREIGN KEY FK_1F30E8451E5D0459');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF459027487');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C59027487');
        $this->addSql('ALTER TABLE realise_test DROP FOREIGN KEY FK_1F30E845FB88E14F');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE mot');
        $this->addSql('DROP TABLE mot_liste');
        $this->addSql('DROP TABLE realise_test');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE utilisateur');
    }
}
