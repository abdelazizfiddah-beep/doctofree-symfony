<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['specialite:list']]),
        new Get(normalizationContext: ['groups' => ['specialite:read']]),
        new Post(denormalizationContext: ['groups' => ['specialite:write']]),
        new Put(denormalizationContext: ['groups' => ['specialite:write']]),
        new Delete()
    ],
    order: ['libelle' => 'ASC']
)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['specialite:list', 'specialite:read', 'medecin:list', 'medecin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le libellé est obligatoire')]
    #[Groups(['specialite:list', 'specialite:read', 'specialite:write', 'medecin:list', 'medecin:read'])]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Medecin::class, mappedBy: 'specialites')]
    #[Groups(['specialite:read'])]
    private Collection $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
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
            $medecin->addSpecialite($this);
        }
        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        if ($this->medecins->removeElement($medecin)) {
            $medecin->removeSpecialite($this);
        }
        return $this;
    }
}
