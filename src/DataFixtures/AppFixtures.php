<?php

namespace App\DataFixtures;

use App\Entity\Cabinet;
use App\Entity\Consultation;
use App\Entity\Medicament;
use App\Entity\Medecin;
use App\Entity\Ordonnance;
use App\Entity\Patient;
use App\Entity\Prescription;
use App\Entity\RendezVous;
use App\Entity\Specialite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // === SPÉCIALITÉS ===
        $specialite1 = new Specialite();
        $specialite1->setLibelle('Cardiologie');
        $manager->persist($specialite1);

        $specialite2 = new Specialite();
        $specialite2->setLibelle('Dermatologie');
        $manager->persist($specialite2);

        $specialite3 = new Specialite();
        $specialite3->setLibelle('Pédiatrie');
        $manager->persist($specialite3);

        // === CABINETS ===
        $cabinet1 = new Cabinet();
        $cabinet1->setNom('Cabinet Central');
        $cabinet1->setAdresse('10 rue de la République, Moulins');
        $cabinet1->setTelephone('0470000001');
        $manager->persist($cabinet1);

        $cabinet2 = new Cabinet();
        $cabinet2->setNom('Cabinet Nord');
        $cabinet2->setAdresse('25 avenue du Parc, Vichy');
        $cabinet2->setTelephone('0470000002');
        $manager->persist($cabinet2);

        // === MÉDECINS ===
        $medecin1 = new Medecin();
        $medecin1->setNom('Dupont');
        $medecin1->setPrenom('Marie');
        $medecin1->setTelephone('0600000001');
        $medecin1->setEmail('marie.dupont@example.com');
        $medecin1->setRpps('10000000001');
        $medecin1->addSpecialite($specialite1);
        $medecin1->addCabinet($cabinet1);
        $medecin1->addCabinet($cabinet2);
        $manager->persist($medecin1);

        $medecin2 = new Medecin();
        $medecin2->setNom('Martin');
        $medecin2->setPrenom('Paul');
        $medecin2->setTelephone('0600000002');
        $medecin2->setEmail('paul.martin@example.com');
        $medecin2->setRpps('10000000002');
        $medecin2->addSpecialite($specialite2);
        $medecin2->addCabinet($cabinet1);
        $manager->persist($medecin2);

        $medecin3 = new Medecin();
        $medecin3->setNom('Bernard');
        $medecin3->setPrenom('Sophie');
        $medecin3->setTelephone('0600000003');
        $medecin3->setEmail('sophie.bernard@example.com');
        $medecin3->setRpps('10000000003');
        $medecin3->addSpecialite($specialite3);
        $medecin3->addCabinet($cabinet2);
        $manager->persist($medecin3);

        // === PATIENTS ===
        $patient1 = new Patient();
        $patient1->setNom('Durand');
        $patient1->setPrenom('Luc');
        $patient1->setEmail('luc.durand@example.com');
        $patient1->setTelephone('0700000001');
        $patient1->setDateNaissance(new \DateTimeImmutable('1985-03-15'));
        $patient1->setNumeroSecuriteSociale('185037512345678');
        $patient1->setDateInscription(new \DateTimeImmutable('now'));
        $manager->persist($patient1);

        $patient2 = new Patient();
        $patient2->setNom('Petit');
        $patient2->setPrenom('Emma');
        $patient2->setEmail('emma.petit@example.com');
        $patient2->setTelephone('0700000002');
        $patient2->setDateNaissance(new \DateTimeImmutable('1992-07-22'));
        $patient2->setNumeroSecuriteSociale('292077512345678');
        $patient2->setDateInscription(new \DateTimeImmutable('now'));
        $manager->persist($patient2);

        $patient3 = new Patient();
        $patient3->setNom('Robert');
        $patient3->setPrenom('Hugo');
        $patient3->setEmail('hugo.robert@example.com');
        $patient3->setTelephone('0700000003');
        $patient3->setDateNaissance(new \DateTimeImmutable('2010-11-05'));
        $patient3->setNumeroSecuriteSociale('310117512345678');
        $patient3->setDateInscription(new \DateTimeImmutable('now'));
        $manager->persist($patient3);

        // === RENDEZ-VOUS ===
        $rdv1 = new RendezVous();
        $rdv1->setDateHeure(new \DateTimeImmutable('+1 day 09:00'));
        $rdv1->setDuree(30);
        $rdv1->setMotif('Contrôle annuel');
        $rdv1->setStatut('planifie');
        $rdv1->setPatient($patient1);
        $rdv1->setMedecin($medecin1);
        $manager->persist($rdv1);

        $rdv2 = new RendezVous();
        $rdv2->setDateHeure(new \DateTimeImmutable('+2 day 10:30'));
        $rdv2->setDuree(20);
        $rdv2->setMotif('Douleurs cutanées');
        $rdv2->setStatut('planifie');
        $rdv2->setPatient($patient2);
        $rdv2->setMedecin($medecin2);
        $manager->persist($rdv2);

        $rdv3 = new RendezVous();
        $rdv3->setDateHeure(new \DateTimeImmutable('+3 day 14:00'));
        $rdv3->setDuree(25);
        $rdv3->setMotif('Suivi enfant');
        $rdv3->setStatut('planifie');
        $rdv3->setPatient($patient3);
        $rdv3->setMedecin($medecin3);
        $manager->persist($rdv3);

        // === MÉDICAMENTS ===
        $medicament1 = new Medicament();
        $medicament1->setNom('Doliprane');
        $medicament1->setDci('Paracétamol');
        $medicament1->setForme('comprime');
        $medicament1->setDosage('500 mg');
        $manager->persist($medicament1);

        $medicament2 = new Medicament();
        $medicament2->setNom('Vitamine C');
        $medicament2->setDci('Acide ascorbique');
        $medicament2->setForme('comprime_effervescent');
        $medicament2->setDosage('1000 mg');
        $manager->persist($medicament2);

        $medicament3 = new Medicament();
        $medicament3->setNom('Amoxicilline');
        $medicament3->setDci('Amoxicilline');
        $medicament3->setForme('gelule');
        $medicament3->setDosage('500 mg');
        $manager->persist($medicament3);

        // === CONSULTATIONS ===
        $consultation1 = new Consultation();
        $consultation1->setDate(new \DateTimeImmutable('now'));
        $consultation1->setAnamnese('Patient se plaint de fatigue chronique.');
        $consultation1->setDiagnostic('Carence en vitamines probable.');
        $consultation1->setNotes('Prescrire bilan sanguin complet.');
        $consultation1->setRendezVous($rdv1);
        $consultation1->setMedecin($medecin1);
        $manager->persist($consultation1);

        // === ORDONNANCES ===
        $ordonnance1 = new Ordonnance();
        $ordonnance1->setDateEmission(new \DateTimeImmutable('now'));
        $ordonnance1->setDateValidite(new \DateTimeImmutable('+3 months'));
        $ordonnance1->setInstructions('Prendre les médicaments après les repas.');
        $ordonnance1->setConsultation($consultation1);
        $manager->persist($ordonnance1);

        // === PRESCRIPTIONS ===
        $prescription1 = new Prescription();
        $prescription1->setPosologie('1 comprimé matin et soir');
        $prescription1->setFrequence('2 fois par jour');
        $prescription1->setDureeJours(7);
        $prescription1->setQuantite(14);
        $prescription1->setMedicament($medicament1);
        $prescription1->setOrdonnance($ordonnance1);
        $manager->persist($prescription1);

        $prescription2 = new Prescription();
        $prescription2->setPosologie('1 comprimé le matin');
        $prescription2->setFrequence('1 fois par jour');
        $prescription2->setDureeJours(30);
        $prescription2->setQuantite(30);
        $prescription2->setMedicament($medicament2);
        $prescription2->setOrdonnance($ordonnance1);
        $manager->persist($prescription2);

        $manager->flush();
    }
}
