<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['rdv:list']]),
        new Get(normalizationContext: ['groups' => ['rdv:read']]),
        new Post(denormalizationContext: ['groups' => ['rdv:write']]),
        new Put(denormalizationContext: ['groups' => ['rdv:write']]),
        new Patch(denormalizationContext: ['groups' => ['rdv:write']]),
        new Delete()
    ],
    order: ['dateHeure' => 'ASC'],
    paginationItemsPerPage: 20
)]
#[ApiFilter(DateFilter::class, properties: ['dateHeure'])]
#[ApiFilter(SearchFilter::class, properties: ['statut' => 'exact', 'medecin.id' => 'exact', 'patient.id' => 'exact'])]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['rdv:list', 'rdv:read', 'patient:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La date et heure sont obligatoires')]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write', 'patient:read'])]
    private ?\DateTimeImmutable $dateHeure = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write'])]
    private ?int $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write'])]
    private ?string $motif = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: ['planifie', 'confirme', 'annule', 'termine'], message: 'Statut invalide')]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write'])]
    private ?string $statut = 'planifie';

    #[ORM\ManyToOne(inversedBy: 'rendezVous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le patient est obligatoire')]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write'])]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le médecin est obligatoire')]
    #[Groups(['rdv:list', 'rdv:read', 'rdv:write'])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(mappedBy: 'rendezVous', cascade: ['persist', 'remove'])]
    #[Groups(['rdv:read'])]
    private ?Consultation $consultation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTimeImmutable
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeImmutable $dateHeure): static
    {
        $this->dateHeure = $dateHeure;
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;
        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;
        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;
        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        if ($consultation === null && $this->consultation !== null) {
            $this->consultation->setRendezVous(null);
        }
        if ($consultation !== null && $consultation->getRendezVous() !== $this) {
            $consultation->setRendezVous($this);
        }
        $this->consultation = $consultation;
        return $this;
    }
}
