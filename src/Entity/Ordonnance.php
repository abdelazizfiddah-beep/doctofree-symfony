<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['ordonnance:list']]),
        new Get(normalizationContext: ['groups' => ['ordonnance:read']]),
        new Post(denormalizationContext: ['groups' => ['ordonnance:write']]),
        new Put(denormalizationContext: ['groups' => ['ordonnance:write']]),
        new Delete()
    ],
    order: ['dateEmission' => 'DESC']
)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'ordonnance:write'])]
    private ?\DateTimeImmutable $dateEmission = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'ordonnance:write'])]
    private ?\DateTimeImmutable $dateValidite = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['ordonnance:read', 'ordonnance:write'])]
    private ?string $instructions = null;

    #[ORM\OneToOne(inversedBy: 'ordonnance')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'ordonnance:write'])]
    private ?Consultation $consultation = null;

    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'ordonnance', cascade: ['persist', 'remove'])]
    #[Groups(['ordonnance:read'])]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmission(): ?\DateTimeImmutable
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeImmutable $dateEmission): static
    {
        $this->dateEmission = $dateEmission;
        return $this;
    }

    public function getDateValidite(): ?\DateTimeImmutable
    {
        return $this->dateValidite;
    }

    public function setDateValidite(\DateTimeImmutable $dateValidite): static
    {
        $this->dateValidite = $dateValidite;
        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): static
    {
        $this->instructions = $instructions;
        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;
        return $this;
    }

    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->setOrdonnance($this);
        }
        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            if ($prescription->getOrdonnance() === $this) {
                $prescription->setOrdonnance(null);
            }
        }
        return $this;
    }
}
