<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['consultation:list']]),
        new Get(normalizationContext: ['groups' => ['consultation:read']]),
        new Post(denormalizationContext: ['groups' => ['consultation:write']]),
        new Put(denormalizationContext: ['groups' => ['consultation:write']]),
        new Patch(denormalizationContext: ['groups' => ['consultation:write']]),
        new Delete()
    ],
    order: ['date' => 'DESC']
)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['consultation:list', 'consultation:read', 'rdv:read', 'ordonnance:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['consultation:list', 'consultation:read', 'consultation:write'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['consultation:read', 'consultation:write'])]
    private ?string $anamnese = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['consultation:read', 'consultation:write'])]
    private ?string $diagnostic = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['consultation:read', 'consultation:write'])]
    private ?string $notes = null;

    #[ORM\OneToOne(inversedBy: 'consultation', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['consultation:list', 'consultation:read', 'consultation:write'])]
    private ?RendezVous $rendezVous = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['consultation:list', 'consultation:read', 'consultation:write'])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(mappedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[Groups(['consultation:read'])]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getAnamnese(): ?string
    {
        return $this->anamnese;
    }

    public function setAnamnese(?string $anamnese): static
    {
        $this->anamnese = $anamnese;
        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(?string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(?RendezVous $rendezVous): static
    {
        $this->rendezVous = $rendezVous;
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

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): static
    {
        if ($ordonnance === null && $this->ordonnance !== null) {
            $this->ordonnance->setConsultation(null);
        }
        if ($ordonnance !== null && $ordonnance->getConsultation() !== $this) {
            $ordonnance->setConsultation($this);
        }
        $this->ordonnance = $ordonnance;
        return $this;
    }
}
