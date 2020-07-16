<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComptabiliteLineRepository")
 */
class ComptabiliteLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $passif;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $actif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comptabilite", inversedBy="lignes")
     */
    private $comptabilite;

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

    public function getPassif(): ?float
    {
        return $this->passif;
    }

    public function setPassif(?float $passif): self
    {
        $this->passif = $passif;

        return $this;
    }

    public function getActif(): ?float
    {
        return $this->actif;
    }

    public function setActif(float $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getComptabilite(): ?Comptabilite
    {
        return $this->comptabilite;
    }

    public function setComptabilite(?Comptabilite $comptabilite): self
    {
        $this->comptabilite = $comptabilite;

        return $this;
    }
}
