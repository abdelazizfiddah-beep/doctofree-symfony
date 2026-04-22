<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\CabinetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CabinetRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['cabinet:list']]),
        new Get(normalizationContext: ['groups' => ['cabinet:read']]),
        new Post(denormalizationContext: ['groups' => ['cabinet:write']]),
        new Put(denormalizationContext: ['groups' => ['cabinet:write']]),
        new Patch(denormalizationContext: ['groups' => ['cabinet:write']]),
        new Delete()
    ],
    order: ['nom' => 'ASC']
)]
class Cabinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cabinet:list', 'cabinet:read', 'medecin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Groups(['cabinet:list', 'cabinet:read', 'cabinet:write', 'medecin:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['cabinet:list', 'cabinet:read', 'cabinet:write', 'medecin:read'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Groups(['cabinet:read', 'cabinet:write'])]
    private ?string $telephone = null;

    #[ORM\ManyToMany(targetEntity: Medecin::class, mappedBy: 'cabinets')]
    #[Groups(['cabinet:read'])]
    private Collection $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
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

    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): static
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins->add($medecin);
            $medecin->addCabinet($this);
        }
        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        if ($this->medecins->removeElement($medecin)) {
            $medecin->removeCabinet($this);
        }
        return $this;
    }
}
