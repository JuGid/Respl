<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComptabiliteRepository")
 */
class Comptabilite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComptabiliteLine", mappedBy="comptabilite")
     */
    private $lignes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptabilites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
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
     * @return Collection|ComptabiliteLine[]
     */
    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function addLigne(ComptabiliteLine $ligne): self
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes[] = $ligne;
            $ligne->setComptabilite($this);
        }

        return $this;
    }

    public function removeLigne(ComptabiliteLine $ligne): self
    {
        if ($this->lignes->contains($ligne)) {
            $this->lignes->removeElement($ligne);
            // set the owning side to null (unless already changed)
            if ($ligne->getComptabilite() === $this) {
                $ligne->setComptabilite(null);
            }
        }

        return $this;
    }

    public function getTotal()
    {
      $total = [0,0];
      foreach($this->lignes as $ligne) {
        if(null !== $ligne->getActif()) {
          $total[0] = $total[0] + $ligne->getActif();
        }

        if(null !== $ligne->getPassif()) {
          $total[1] = $total[1] + $ligne->getPassif();
        }
      }

      return $total;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

}
