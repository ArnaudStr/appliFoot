<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=SaisonJoueur::class, mappedBy="club", orphanRemoval=true)
     */
    private $saisonsJoueurs;

    /**
     * @ORM\OneToMany(targetEntity=Logo::class, mappedBy="club")
     */
    private $logos;

    public function __construct()
    {
        $this->saisonsJoueurs = new ArrayCollection();
        $this->logos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|SaisonJoueur[]
     */
    public function getSaisonsJoueurs(): Collection
    {
        return $this->saisonsJoueurs;
    }

    public function addSaisonsJoueur(SaisonJoueur $saisonsJoueur): self
    {
        if (!$this->saisonsJoueurs->contains($saisonsJoueur)) {
            $this->saisonsJoueurs[] = $saisonsJoueur;
            $saisonsJoueur->setClub($this);
        }

        return $this;
    }

    public function removeSaisonsJoueur(SaisonJoueur $saisonsJoueur): self
    {
        if ($this->saisonsJoueurs->removeElement($saisonsJoueur)) {
            // set the owning side to null (unless already changed)
            if ($saisonsJoueur->getClub() === $this) {
                $saisonsJoueur->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|logo[]
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    public function addLogo(logo $logo): self
    {
        if (!$this->logos->contains($logo)) {
            $this->logos[] = $logo;
            $logo->setClub($this);
        }

        return $this;
    }

    public function removeLogo(logo $logo): self
    {
        if ($this->logos->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getClub() === $this) {
                $logo->setClub(null);
            }
        }

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString(){
        return ucfirst($this->getNom());
    }
}
