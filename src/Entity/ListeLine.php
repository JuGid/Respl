<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListeLineRepository")
 */
class ListeLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Liste", inversedBy="lignes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $liste;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $optionnel;

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

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getListe(): ?Liste
    {
        return $this->liste;
    }

    public function setListe(?Liste $liste): self
    {
        $this->liste = $liste;

        return $this;
    }

    public function getOptionnel(): ?bool
    {
        return $this->optionnel;
    }

    public function setOptionnel(?bool $optionnel): self
    {
        $this->optionnel = $optionnel;

        return $this;
    }
}
