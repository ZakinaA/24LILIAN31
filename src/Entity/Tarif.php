<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\ManyToMany(targetEntity: TypeCours::class, mappedBy: 'tarif')]
    private Collection $typeCours;

    public function __construct()
    {
        $this->typeCours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, TypeCours>
     */
    public function getTypeCours(): Collection
    {
        return $this->typeCours;
    }

    public function addTypeCour(TypeCours $typeCour): static
    {
        if (!$this->typeCours->contains($typeCour)) {
            $this->typeCours->add($typeCour);
            $typeCour->addTarif($this);
        }

        return $this;
    }

    public function removeTypeCour(TypeCours $typeCour): static
    {
        if ($this->typeCours->removeElement($typeCour)) {
            $typeCour->removeTarif($this);
        }

        return $this;
    }
}
