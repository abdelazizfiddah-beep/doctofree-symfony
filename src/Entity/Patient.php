<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['patient:list']]),
        new Get(normalizationContext: ['groups' => ['patient:read']]),
        new Post(denormalizationContext: ['groups' => ['patient:write']]),
        new Put(denormalizationContext: ['groups' => ['patient:write']]),
        new Patch(denormalizationContext: ['groups' => ['patient:write']]),
        new Delete()
    ],
    order: ['nom' => 'ASC'],
    paginationItemsPerPage: 10
)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['patient:list', 'patient:read', 'rdv:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(max: 100)]
    #[Groups(['patient:list', 'patient:read', 'patient:write', 'rdv:read', 'consultation:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Length(max: 100)]
    #[Groups(['patient:list', 'patient:read', 'patient:write', 'rdv:read', 'consultation:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email(message: 'Email invalide')]
    #[Groups(['patient:read', 'patient:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Groups(['patient:read', 'patient:write'])]
    private ?string $telephone = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['patient:read', 'patient:write'])]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 15, exactMessage: 'Le numéro de sécurité sociale doit contenir 15 caractères')]
    #[Groups(['patient:read', 'patient:write'])]
    private ?string $numeroSecuriteSociale = null;

    #[ORM\Column]
    #[Groups(['patient:read'])]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'patient')]
    #[Groups(['patient:read'])]
    private Collection $rendezVous;

    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->dateInscription = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getNumeroSecuriteSociale(): ?string
    {
        return $this->numeroSecuriteSociale;
    }

    public function setNumeroSecuriteSociale(string $numeroSecuriteSociale): static
    {
        $this->numeroSecuriteSociale = $numeroSecuriteSociale;
        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeImmutable $dateInscription): static
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVous(RendezVous $rendezVous): static
    {
        if (!$this->rendezVous->contains($rendezVous)) {
            $this->rendezVous->add($rendezVous);
            $rendezVous->setPatient($this);
        }
        return $this;
    }

    public function removeRendezVous(RendezVous $rendezVous): static
    {
        if ($this->rendezVous->removeElement($rendezVous)) {
            if ($rendezVous->getPatient() === $this) {
                $rendezVous->setPatient(null);
            }
        }
        return $this;
    }
}
