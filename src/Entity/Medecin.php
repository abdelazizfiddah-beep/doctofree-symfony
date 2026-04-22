<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 11)]
    private ?string $rpps = null;

    /**
     * @var Collection<int, Specialite>
     */
    #[ORM\ManyToMany(targetEntity: Specialite::class)]
    private Collection $specialites;

    /**
     * @var Collection<int, Cabinet>
     */
    #[ORM\ManyToMany(targetEntity: Cabinet::class)]
    private Collection $cabinets;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
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

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

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

    /**
     * @return Collection<int, Specialite>
     */
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

    /**
     * @return Collection<int, Cabinet>
     */
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
}
