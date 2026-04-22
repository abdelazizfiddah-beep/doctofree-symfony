<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422134816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cabinet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, anamnese LONGTEXT DEFAULT NULL, diagnostic LONGTEXT DEFAULT NULL, notes LONGTEXT DEFAULT NULL, rendez_vous_id INT NOT NULL, medecin_id INT NOT NULL, UNIQUE INDEX UNIQ_964685A691EF7EAA (rendez_vous_id), INDEX IDX_964685A64F31A84 (medecin_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(20) NOT NULL, email VARCHAR(180) NOT NULL, rpps VARCHAR(11) NOT NULL, UNIQUE INDEX UNIQ_1BDA53C652B0862B (rpps), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medecin_specialite (medecin_id INT NOT NULL, specialite_id INT NOT NULL, INDEX IDX_3F5A311B4F31A84 (medecin_id), INDEX IDX_3F5A311B2195E0F0 (specialite_id), PRIMARY KEY (medecin_id, specialite_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medecin_cabinet (medecin_id INT NOT NULL, cabinet_id INT NOT NULL, INDEX IDX_32C4C08D4F31A84 (medecin_id), INDEX IDX_32C4C08DD351EC (cabinet_id), PRIMARY KEY (medecin_id, cabinet_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, dci VARCHAR(150) NOT NULL, forme VARCHAR(50) NOT NULL, dosage VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, date_emission DATETIME NOT NULL, date_validite DATETIME NOT NULL, instructions LONGTEXT DEFAULT NULL, consultation_id INT NOT NULL, UNIQUE INDEX UNIQ_924B326C62FF6CDF (consultation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(20) NOT NULL, date_naissance DATETIME NOT NULL, numero_securite_sociale VARCHAR(15) NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, posologie VARCHAR(255) NOT NULL, frequence VARCHAR(100) NOT NULL, duree_jours INT NOT NULL, quantite INT NOT NULL, medicament_id INT NOT NULL, ordonnance_id INT NOT NULL, INDEX IDX_1FBFB8D9AB0D61F7 (medicament_id), INDEX IDX_1FBFB8D92BF23B8F (ordonnance_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree INT NOT NULL, motif VARCHAR(255) DEFAULT NULL, statut VARCHAR(20) NOT NULL, patient_id INT NOT NULL, medecin_id INT NOT NULL, INDEX IDX_65E8AA0A6B899279 (patient_id), INDEX IDX_65E8AA0A4F31A84 (medecin_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A691EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE medecin_specialite ADD CONSTRAINT FK_3F5A311B4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medecin_specialite ADD CONSTRAINT FK_3F5A311B2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medecin_cabinet ADD CONSTRAINT FK_32C4C08D4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medecin_cabinet ADD CONSTRAINT FK_32C4C08DD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D92BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A691EF7EAA');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A64F31A84');
        $this->addSql('ALTER TABLE medecin_specialite DROP FOREIGN KEY FK_3F5A311B4F31A84');
        $this->addSql('ALTER TABLE medecin_specialite DROP FOREIGN KEY FK_3F5A311B2195E0F0');
        $this->addSql('ALTER TABLE medecin_cabinet DROP FOREIGN KEY FK_32C4C08D4F31A84');
        $this->addSql('ALTER TABLE medecin_cabinet DROP FOREIGN KEY FK_32C4C08DD351EC');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C62FF6CDF');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D9AB0D61F7');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D92BF23B8F');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B899279');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('DROP TABLE cabinet');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE medecin_specialite');
        $this->addSql('DROP TABLE medecin_cabinet');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
