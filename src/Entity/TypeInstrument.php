<?php

namespace App\Entity;

use App\Repository\TypeInstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeInstrumentRepository::class)]
class TypeInstrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Professeur::class, mappedBy: 'typeInstrument')]
    private Collection $professeurs;

    #[ORM\ManyToOne(inversedBy: 'typeInstruments')]
    private ?ClasseInstrument $classeInstrument = null;

    #[ORM\OneToMany(targetEntity: Instrument::class, mappedBy: 'typeInstrument')]
    private Collection $instruments;

    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'typeInstrument')]
    private Collection $cours;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
        $this->instruments = new ArrayCollection();
        $this->cours = new ArrayCollection();
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
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): static
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
            $professeur->addTypeInstrument($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): static
    {
        if ($this->professeurs->removeElement($professeur)) {
            $professeur->removeTypeInstrument($this);
        }

        return $this;
    }

    public function getClasseInstrument(): ?ClasseInstrument
    {
        return $this->classeInstrument;
    }

    public function setClasseInstrument(?ClasseInstrument $classeInstrument): static
    {
        $this->classeInstrument = $classeInstrument;

        return $this;
    }

    /**
     * @return Collection<int, Instrument>
     */
    public function getInstruments(): Collection
    {
        return $this->instruments;
    }

    public function addInstrument(Instrument $instrument): static
    {
        if (!$this->instruments->contains($instrument)) {
            $this->instruments->add($instrument);
            $instrument->setTypeInstrument($this);
        }

        return $this;
    }

    public function removeInstrument(Instrument $instrument): static
    {
        if ($this->instruments->removeElement($instrument)) {
            // set the owning side to null (unless already changed)
            if ($instrument->getTypeInstrument() === $this) {
                $instrument->setTypeInstrument(null);
            }
        }

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
            $cour->setTypeInstrument($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTypeInstrument() === $this) {
                $cour->setTypeInstrument(null);
            }
        }

        return $this;
    }
}
