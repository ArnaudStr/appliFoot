<?php

namespace App\Entity;

use App\Repository\SaisonJoueurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaisonJoueurRepository::class)
 */
class SaisonJoueur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbButs;

    /**
     * @ORM\ManyToOne(targetEntity=Joueur::class, inversedBy="saisonsJoueur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $joueur;

    /**
     * @ORM\ManyToOne(targetEntity=Saison::class, inversedBy="saisonJoueurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="saisonsJoueurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroMaillot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbButs(): ?int
    {
        return $this->nbButs;
    }

    public function setNbButs(int $nbButs): self
    {
        $this->nbButs = $nbButs;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getNumeroMaillot(): ?int
    {
        return $this->numeroMaillot;
    }

    public function setNumeroMaillot(int $numeroMaillot): self
    {
        $this->numeroMaillot = $numeroMaillot;

        return $this;
    }
}
