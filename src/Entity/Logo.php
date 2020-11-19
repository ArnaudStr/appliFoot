<?php

namespace App\Entity;

use App\Repository\LogoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogoRepository::class)
 */
class Logo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="logos")
     */
    private $club;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeParution;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFin;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnneeParution(): ?int
    {
        return $this->anneeParution;
    }

    public function setAnneeParution(int $anneeParution): self
    {
        $this->anneeParution = $anneeParution;

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(?int $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

}
