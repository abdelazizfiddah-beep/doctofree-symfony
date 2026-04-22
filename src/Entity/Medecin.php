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
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['medecin:list']]),
        new Get(normalizationContext: ['groups' => ['medecin:read']]),
        new Post(denormalizationContext: ['groups' => ['medecin:write']]),
        new Put(denormalizationContext: ['groups' => ['medecin:write']]),
        new Patch(denormalizationContext: ['groups' => ['medecin:write']]),
        new Delete()
    ],
    order: ['nom' => 'ASC'],
    paginationItemsPerPage: 10
)]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial', 'specialites.libelle' => 'partial'])]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medecin:list', 'medecin:read', 'rdv:read', 'consultation:read', 'cabinet:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Groups(['medecin:list', 'medecin:read', 'medecin:write', 'rdv:read', 'consultation:read', 'cabinet:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Groups(['medecin:list', 'medecin:read', 'medecin:write', 'rdv:read', 'consultation:read', 'cabinet:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 11, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 11, exactMessage: 'Le RPPS doit contenir 11 caractères')]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $rpps = null;

    #[ORM\ManyToMany(targetEntity: Specialite::class, inversedBy: 'medecins')]
    #[Groups(['medecin:list', 'medecin:read', 'medecin:write'])]
    private Collection $specialites;

    #[ORM\ManyToMany(targetEntity: Cabinet::class, inversedBy: 'medecins')]
    #[Groups(['medecin:read', 'medecin:write'])]
    private Collection $cabinets;

    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'medecin')]
    private Collection $rendezVous;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'medecin')]
    private Collection $consultations;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
        $this->rendezVous = new ArrayCollection();
        $this->consultations = new ArrayCollection();
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
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

    public function getRpps(): ?string
    {
        return $this->rpps;
    }

    public function setRpps(string $rpps): static
    {
        $this->rpps = $rpps;
        return $this;
    }

    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialite $specialite): static
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites->add($specialite);
        }
        return $this;
    }

    public function removeSpecialite(Specialite $specialite): static
    {
        $this->specialites->removeElement($specialite);
        return $this;
    }

    public function getCabinets(): Collection
    {
        return $this->cabinets;
    }

    public function addCabinet(Cabinet $cabinet): static
    {
        if (!$this->cabinets->contains($cabinet)) {
            $this->cabinets->add($cabinet);
        }
        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        $this->cabinets->removeElement($cabinet);
        return $this;
    }

    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function getConsultations(): Collection
    {
        return $this->consultations;
    }
}
