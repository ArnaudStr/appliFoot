<?php

namespace App\Entity;

use App\Repository\SaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaisonRepository::class)
 */
class Saison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=SaisonJoueur::class, mappedBy="saison", orphanRemoval=true)
     */
    private $saisonJoueurs;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeFin;

    public function __construct()
    {
        $this->saisonJoueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|SaisonJoueur[]
     */
    public function getSaisonJoueurs(): Collection
    {
        return $this->saisonJoueurs;
    }

    public function addSaisonJoueur(SaisonJoueur $saisonJoueur): self
    {
        if (!$this->saisonJoueurs->contains($saisonJoueur)) {
            $this->saisonJoueurs[] = $saisonJoueur;
            $saisonJoueur->setSaison($this);
        }

        return $this;
    }

    public function removeSaisonJoueur(SaisonJoueur $saisonJoueur): self
    {
        if ($this->saisonJoueurs->removeElement($saisonJoueur)) {
            // set the owning side to null (unless already changed)
            if ($saisonJoueur->getSaison() === $this) {
                $saisonJoueur->setSaison(null);
            }
        }

        return $this;
    }

    public function getAnneeDebut(): ?int
    {
        return $this->anneeDebut;
    }

    public function setAnneeDebut(int $anneeDebut): self
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(int $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    /**
     * toString
     * @return string
     * Pour afficher la saison sous le format '2020/2021' par exemple
     */
    public function __toString(){
        return $this->getAnneeDebut().'/'.$this->getAnneeFin();
    }

}
