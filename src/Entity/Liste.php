<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListeRepository")
 */
class Liste
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListeLine", mappedBy="liste", orphanRemoval=true)
     */
    private $lignes;

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

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|ListeLine[]
     */
    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function addLigne(ListeLine $ligne): self
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes[] = $ligne;
            $ligne->setListe($this);
        }

        return $this;
    }

    public function removeLigne(ListeLine $ligne): self
    {
        if ($this->lignes->contains($ligne)) {
            $this->lignes->removeElement($ligne);
            // set the owning side to null (unless already changed)
            if ($ligne->getListe() === $this) {
                $ligne->setListe(null);
            }
        }

        return $this;
    }

    public function getTotal()
    {
      $total = 0;
      foreach($this->lignes as $ligne) {
        $total+= $ligne->getPrix();
      }
      return $total;
    }

    public function getNombrebObligatoire()
    {
      $element = 0;
      foreach($this->lignes as $ligne) {
        if(!$ligne->getOptionnel()) {
          $element+= 1;
        }
      }
      return $element;
    }
}
