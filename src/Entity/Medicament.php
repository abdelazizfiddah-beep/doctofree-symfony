<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['medicament:list']]),
        new Get(normalizationContext: ['groups' => ['medicament:read']]),
        new Post(denormalizationContext: ['groups' => ['medicament:write']]),
        new Put(denormalizationContext: ['groups' => ['medicament:write']]),
        new Delete()
    ],
    order: ['nom' => 'ASC'],
    paginationItemsPerPage: 50
)]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial', 'dci' => 'partial'])]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medicament:list', 'medicament:read', 'prescription:read', 'ordonnance:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Groups(['medicament:list', 'medicament:read', 'medicament:write', 'prescription:read', 'ordonnance:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Groups(['medicament:list', 'medicament:read', 'medicament:write'])]
    private ?string $dci = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['comprime', 'gelule', 'sirop', 'injection', 'pommade', 'collyre', 'suppositoire', 'comprime_effervescent'], message: 'Forme invalide')]
    #[Groups(['medicament:list', 'medicament:read', 'medicament:write', 'prescription:read'])]
    private ?string $forme = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Groups(['medicament:list', 'medicament:read', 'medicament:write', 'prescription:read'])]
    private ?string $dosage = null;

    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'medicament')]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
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

    public function getDci(): ?string
    {
        return $this->dci;
    }

    public function setDci(string $dci): static
    {
        $this->dci = $dci;
        return $this;
    }

    public function getForme(): ?string
    {
        return $this->forme;
    }

    public function setForme(string $forme): static
    {
        $this->forme = $forme;
        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;
        return $this;
    }

    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }
}
