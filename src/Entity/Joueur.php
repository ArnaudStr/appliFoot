<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JoueurRepository::class)
 */
class Joueur
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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=SaisonJoueur::class, mappedBy="joueur", orphanRemoval=true)
     */
    private $saisonsJoueur;

    public function __construct()
    {
        $this->saisonsJoueur = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|SaisonJoueur[]
     */
    public function getSaisonsJoueur(): Collection
    {
        return $this->saisonsJoueur;
    }

    public function addSaisonsJoueur(SaisonJoueur $saisonsJoueur): self
    {
        if (!$this->saisonsJoueur->contains($saisonsJoueur)) {
            $this->saisonsJoueur[] = $saisonsJoueur;
            $saisonsJoueur->setJoueur($this);
        }

        return $this;
    }

    public function removeSaisonsJoueur(SaisonJoueur $saisonsJoueur): self
    {
        if ($this->saisonsJoueur->removeElement($saisonsJoueur)) {
            // set the owning side to null (unless already changed)
            if ($saisonsJoueur->getJoueur() === $this) {
                $saisonsJoueur->setJoueur(null);
            }
        }

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString(){
        return $this->getNom().' '.$this->getPrenom();
    }
}
