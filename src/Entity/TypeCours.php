<?php

namespace App\Entity;

use App\Repository\TypeCoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeCoursRepository::class)]
class TypeCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'typeCours')]
    private Collection $cours;

    #[ORM\ManyToMany(targetEntity: Tarif::class, inversedBy: 'typeCours')]
    private Collection $tarif;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->tarif = new ArrayCollection();
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

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setTypeCours($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTypeCours() === $this) {
                $cour->setTypeCours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tarif>
     */
    public function getTarif(): Collection
    {
        return $this->tarif;
    }

    public function addTarif(Tarif $tarif): static
    {
        if (!$this->tarif->contains($tarif)) {
            $this->tarif->add($tarif);
        }

        return $this;
    }

    public function removeTarif(Tarif $tarif): static
    {
        $this->tarif->removeElement($tarif);

        return $this;
    }
}
