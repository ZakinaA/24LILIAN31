<?php

namespace App\Entity;

use App\Repository\QuotientFamilialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotientFamilialRepository::class)]
class QuotientFamilial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $quotienMini = null;



    /**
     * @var Collection<int, Tarif>
     */
    #[ORM\OneToMany(targetEntity: Tarif::class, mappedBy: 'quotientFamilial')]
    private Collection $tarifs;

    #[ORM\Column(length: 255)]
    private ?string $quotientMax = null;

    /**
     * @var Collection<int, Responsable>
     */
    #[ORM\OneToMany(targetEntity: Responsable::class, mappedBy: 'quotientFamilial')]
    private Collection $responsables;

    public function __construct()
    {
        $this->tarifs = new ArrayCollection();
        $this->responsables = new ArrayCollection();
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

    public function getQuotienMini(): ?string
    {
        return $this->quotienMini;
    }

    public function setQuotienMini(string $quotienMini): static
    {
        $this->quotienMini = $quotienMini;

        return $this;
    }


    /**
     * @return Collection<int, Tarif>
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Tarif $tarif): static
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs->add($tarif);
            $tarif->setQuotientFamilial($this);
        }

        return $this;
    }

    public function removeTarif(Tarif $tarif): static
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getQuotientFamilial() === $this) {
                $tarif->setQuotientFamilial(null);
            }
        }

        return $this;
    }

    public function getQuotientMax(): ?string
    {
        return $this->quotientMax;
    }

    public function setQuotientMax(string $quotientMax): static
    {
        $this->quotientMax = $quotientMax;

        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables->add($responsable);
            $responsable->setQuotientFamilial($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        if ($this->responsables->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getQuotientFamilial() === $this) {
                $responsable->setQuotientFamilial(null);
            }
        }

        return $this;
    }
}
