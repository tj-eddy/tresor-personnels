<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624163611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribution (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_tache VARCHAR(50) DEFAULT NULL, numero_tache VARCHAR(255) DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, status INT NOT NULL, INDEX IDX_C751ED49A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_conge (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, lieu_jouissance VARCHAR(255) DEFAULT NULL, type_conge VARCHAR(255) DEFAULT NULL, motif VARCHAR(255) DEFAULT NULL, nom_interim VARCHAR(255) DEFAULT NULL, num_demande VARCHAR(255) DEFAULT NULL, status INT DEFAULT NULL, nombre_de_jour_demande INT DEFAULT NULL, date_fin VARCHAR(255) DEFAULT NULL, INDEX IDX_D8061061A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, numero VARCHAR(20) DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, nom_diplome VARCHAR(255) DEFAULT NULL, etablissement VARCHAR(255) NOT NULL, scan VARCHAR(255) DEFAULT NULL, INDEX IDX_EB4C4D4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_recrutement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_doc VARCHAR(255) NOT NULL, type_doc VARCHAR(255) NOT NULL, date_doc VARCHAR(255) DEFAULT NULL, corps VARCHAR(255) DEFAULT NULL, indice VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, grade VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, scan_doc VARCHAR(255) DEFAULT NULL, INDEX IDX_A7421473A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_soin (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_fact VARCHAR(255) DEFAULT NULL, date_fact VARCHAR(255) DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, pharmacie VARCHAR(20) DEFAULT NULL, status INT DEFAULT NULL, INDEX IDX_E376EC0EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointage (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_arrive_matinee DATETIME DEFAULT NULL, heure_sortie_matinee DATETIME DEFAULT NULL, heure_arrivee_ap DATETIME DEFAULT NULL, heure_sortie_ap DATETIME DEFAULT NULL, INDEX IDX_7591B20A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE titre_conge (id INT AUTO_INCREMENT NOT NULL, num_decision VARCHAR(255) DEFAULT NULL, titre_annee VARCHAR(255) DEFAULT NULL, type_conge VARCHAR(255) DEFAULT NULL, nombre_jrs_oct VARCHAR(255) DEFAULT NULL, scan_decision_conge VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, titre_conge_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, profil VARCHAR(255) DEFAULT NULL, date_create_or_update DATETIME NOT NULL, child_number INT DEFAULT NULL, cin VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, date_naissance VARCHAR(255) DEFAULT NULL, date_start_service VARCHAR(255) DEFAULT NULL, conge_initial INT DEFAULT NULL, status_tache INT DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, age VARCHAR(5) DEFAULT NULL, anciennete VARCHAR(5) DEFAULT NULL, num_tel VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6491FB7C035 (titre_conge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande_conge ADD CONSTRAINT FK_D8061061A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document_recrutement ADD CONSTRAINT FK_A7421473A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture_soin ADD CONSTRAINT FK_E376EC0EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491FB7C035 FOREIGN KEY (titre_conge_id) REFERENCES titre_conge (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491FB7C035');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49A76ED395');
        $this->addSql('ALTER TABLE demande_conge DROP FOREIGN KEY FK_D8061061A76ED395');
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4EA76ED395');
        $this->addSql('ALTER TABLE document_recrutement DROP FOREIGN KEY FK_A7421473A76ED395');
        $this->addSql('ALTER TABLE facture_soin DROP FOREIGN KEY FK_E376EC0EA76ED395');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE attribution');
        $this->addSql('DROP TABLE demande_conge');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE document_recrutement');
        $this->addSql('DROP TABLE facture_soin');
        $this->addSql('DROP TABLE pointage');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE titre_conge');
        $this->addSql('DROP TABLE user');
    }
}
